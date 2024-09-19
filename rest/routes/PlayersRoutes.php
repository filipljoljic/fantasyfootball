<?php


Flight::route("/", function(){
    echo "Hello";
});

Flight::route("GET /players", function(){
    Flight::json($result = Flight::players_service()->get_all());
});

Flight::route("GET /players/@id", function($id){
    Flight::json(Flight::players_service()->get_by_id($id));
});

Flight::route("DELETE /players/@id", function($id) {
    Flight::players_service()->delete($id);
    Flight::json(["message" => "Player has been deleted"]);
});

Flight::route("POST /players", function(){
    $request = Flight::request()->data->getData();
    error_log(print_r($request, true));
    Flight::json(['message' => "Player added", 'data' => FLight::players_service()->add($request)]);
});

Flight::route("PUT /players/@id", function($id){
    $players = Flight::request()->data->getData();
    Flight::json(['message' => "Player edited", 'data' => Flight::players_service()->update($players, $id)]);
});


?>