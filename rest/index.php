<?php
require "../vendor/autoload.php";

require "dao/UsersDao.class.php";


Flight::route("/", function(){
    echo "Hello";
});

Flight::route("GET /users", function(){
    $user_dao = new UsersDao();
    $result = $user_dao->get_all();
    //print_r($result);
    Flight::json($result);
});

Flight::route("GET /users/@username", function($username){
    echo "Hello users with username " .$username;
});

Flight::route("GET /users/@id", function($id){
    $user_dao = new UsersDao();
    $result = $user_dao->get_by_id($id);
    //print_r($result);
    Flight::json($result);
});

Flight::route("DELETE /users/@id", function($id) {
    $user_dao = new UsersDao();
    $result = $user_dao->delete($id);
    if ($result) {
        Flight::json(["message" => "User has been deleted"]);
    } else {
        Flight::json(["error" => "User could not be deleted"], 400);
    }
});



Flight::route("POST /users", function(){
    $user_dao = new UsersDao();
    $user_dao->add($username, $password, $email);
    //print_r($result);
    Flight::json(["message" => "User has been added"]);
});

Flight::start();



?>