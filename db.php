<?php
require_once("rest/dao/UsersDao.class.php");
$users_dao = new UsersDao();

$result = $users_dao->get_all();
print_r($result);


?>
