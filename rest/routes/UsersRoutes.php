<?php

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


?>