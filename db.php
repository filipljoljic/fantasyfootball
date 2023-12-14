<?php
require_once("rest/dao/UsersDao.class.php");
$users_dao = new UsersDao();

$result = $users_dao->get_all();
print_r($result);
/*
$servername = "localhost";
$username = "root";
$password = "864950sa";
$schema = "fantasyfootball";

try{
    $conn = new PDO("mysql:host=$servername;dbname=$schema", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected";
}   catch(PDOException $e){
    echo "Failed: " . $e->getMessage();
}
*/

?>
