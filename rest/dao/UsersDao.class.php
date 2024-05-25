<?php
require_once "BaseDao.class.php";

class UsersDao extends BaseDao{

    public function __construct(){
        parent::__construct("users"); 
    }

    public function get_by_email($email) {
        return $this->query("SELECT * FROM users WHERE email = :email",['email' => $email]);
        error_log("Result from get_by_email: " . print_r($result, true));  // Log the result
        return $result;
    }

}


?>