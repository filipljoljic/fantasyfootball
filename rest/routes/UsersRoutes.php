<?php


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::route("/", function(){
    echo "Hello";
});

Flight::route("GET /users", function(){
    Flight::json($result = Flight::users_service()->get_all());
});

Flight::route("GET /users/@id", function($id){
    Flight::json(Flight::users_service()->get_by_id($id));
});

Flight::route("DELETE /users/@id", function($id) {
    Flight::users_service()->delete($id);
    Flight::json(["message" => "User has been deleted"]);
});

Flight::route("POST /users", function(){
    $request = Flight::request()->data->getData();
    Flight::json(['message' => "User added", 'data' => FLight::users_service()->add($request)]);
});

Flight::route("PUT /users/@id", function($id){
    $users = Flight::request()->data->getData();
    Flight::json(['message' => "User edited", 'data' => Flight::users_service()->update($users, $id)]);
});

Flight::route("POST /login", function() {
    $login = Flight::request()->data->getData();
    $users = Flight::usersDao()->get_by_email($login['email']);
    
    if(count($users) > 0){
        $user = $users[0];
        
        if($user['Password'] == md5($login['password'])){  
            $_SESSION['user_id'] = $user['ID'];  // Store user ID in session
            
            // Generate JWT token
            $jwt_payload = [
                'user_id' => $user['ID'],
                'email' => $user['Email'],
                'is_admin' => $user['is_admin']
            ];
            
            $jwt_token = JWT::encode($jwt_payload, 'web', 'HS256');
            
            // Return response with token and is_admin flag
            Flight::json([
                'message' => 'Login successful.',
                'token' => $jwt_token,
                'is_admin' => $user['is_admin']
            ]);
        } else {
            Flight::json(['message' => 'Wrong password'], 404);
        }
    } else {
        Flight::json(['message' => 'User not found'], 404);
    }
});


Flight::route("POST /register", function(){
    $request = Flight::request()->data->getData();
    if (isset($request['username']) && isset($request['email']) && isset($request['password'])) {
        $user = [
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => $request['password']
        ];
        $addedUser = Flight::users_service()->add($user);
        Flight::json(['message' => "User registered", 'data' => $addedUser]);
    } else {
        Flight::json(['message' => "Invalid input"], 400);
    }
});

// Flight::route("GET /user/leagues", function() {
//     // Check if the user is logged in
//     // if (!isset($_SESSION['user_id'])) {
//     //     Flight::json(['status' => 'error', 'message' => 'User not logged in.'], 401);
//     //     return;
//     // }

//     $user_id = $_SESSION['user_id'];

//     // Fetch the leagues the user is a member of with their total points
//     $members = Flight::league_members_service()->get_user_leagues_with_members($user_id);
//     $formatted_members = Flight::league_members_service()->format_league_members_with_points($members);
    
//     Flight::json($formatted_members);
// });
Flight::route("GET /user/leagues", function() {
    // Retrieve the Authorization header
    $headers = apache_request_headers();
    
    if (isset($headers['Authorization'])) {
        $jwt_token = str_replace('Bearer ', '', $headers['Authorization']);
        
        try {
            // Correctly decode the JWT token without passing headers by reference
            $secret_key = "web";
            $decoded = JWT::decode($jwt_token, new Key($secret_key, 'HS256'));
            
            // Access user_id from the decoded token
            $user_id = $decoded->user_id;
            
            // Fetch user leagues
            $members = Flight::league_members_service()->get_user_leagues_with_members($user_id);
            $formatted_members = Flight::league_members_service()->format_league_members_with_points($members);
            
            Flight::json($formatted_members);
        } catch (Exception $e) {
            Flight::json(['message' => 'Invalid token: ' . $e->getMessage()], 401);
        }
    } else {
        Flight::json(['message' => 'Authorization header not found.'], 401);
    }
});

Flight::route("GET /check_session", function() {
    if (isset($_SESSION['user_id'])) {
        // Return the session data
        Flight::json([
            'user_id' => $_SESSION['user_id'],
            'is_admin' => isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : 0
        ]);
    } else {
        // User not logged in
        Flight::json(['message' => 'User not logged in'], 401);
    }
});



?>