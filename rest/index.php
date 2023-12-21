<?php

require_once "../vendor/autoload.php";

require_once "dao/UsersDao.class.php";
require_once "dao/PlayersDao.class.php";

require_once "services/UsersService.php";
require_once "services/PlayersService.php";

Flight::register('users_service', "UsersService");
Flight::register('players_service', "PlayersService");

require_once 'routes/UsersRoutes.php';
require_once 'routes/PlayersRoutes.php';

Flight::start();



?>