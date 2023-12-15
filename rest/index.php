<?php

require_once "../vendor/autoload.php";

require_once "dao/UsersDao.class.php";

require_once "services/UsersService.php";

Flight::register('users_service', "UsersService");

require_once 'routes/UsersRoutes.php';

Flight::start();



?>