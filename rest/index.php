<?php

require_once "../vendor/autoload.php";

require_once "dao/UsersDao.class.php";
require_once "dao/PlayersDao.class.php";
require_once "dao/UserSquadDao.class.php";


require_once "services/UsersService.php";
require_once "services/PlayersService.php";
require_once "services/UserSquadService.php";

Flight::register('users_service', "UsersService");
Flight::register('players_service', "PlayersService");
Flight::register('user_squad_service', "UserSquadService");
Flight::register('usersDao', 'UsersDao');

require_once 'routes/UsersRoutes.php';
require_once 'routes/PlayersRoutes.php';
require_once 'routes/UserSquadRoutes.php';


Flight::start();



?>