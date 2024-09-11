<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

Flight::route("GET /league_members", function(){
    Flight::json($result = Flight::league_members_service()->get_all());
});

Flight::route("POST /league_members/join", function(){
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        Flight::json(['status' => 'error', 'message' => 'User not logged in.'], 401);
        return;
    }

    // Get the logged-in user ID from the session
    $user_id = $_SESSION['user_id'];

    // Get the POST data (assuming it's JSON)
    $request = Flight::request();
    $input = json_decode($request->getBody(), true);
    $league_id = $input['league_id'];

    // Call the service to join the league
    $response = Flight::league_members_service()->join_league($user_id, $league_id);

    // Send the response back
    Flight::json($response);
});

?>