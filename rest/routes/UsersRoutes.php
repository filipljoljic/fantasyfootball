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

Flight::route("POST /register", function() {
    try {
        $request = Flight::request()->data->getData();
        $result = Flight::users_service()->register($request);
        Flight::json(['success' => true, 'message' => 'Registration successful']);
    } catch (Exception $e) {
        Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
    }
});

Flight::route("POST /login", function() {
    $login = Flight::request()->data->getData();
    $users = Flight::usersDao()->get_by_email($login['email']);
    if(count($users) > 0){
        $users = $users[0];
        if($users['Password'] == md5($login['password'])){  //password in the database is uppercase
            unset($users['Password']);
            $jwt = JWT::encode($users, Config::JWT_SECRET(), 'HS256');
            Flight::json(['token' => $jwt]);
        } else {
            Flight::json(['message' => 'Wrong password'], 404);
        }
    } else {
        Flight::json(['message' => 'User not found'], 404);
    }
});



?>