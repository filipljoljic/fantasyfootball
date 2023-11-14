<?php

require "vendor/autoload.php";

Flight::route("/", function(){
    echo "Hello flight";
});

Flight::route("GET /test", function(){
    echo "test flight";

});

Flight::start();
?>


