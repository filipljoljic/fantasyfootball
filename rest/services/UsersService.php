<?php
require_once 'BaseService.php';
require_once __DIR__."/../dao/UsersDao.class.php";

class UsersService extends BaseService{
    public function __construct(){
        parent::__construct(new UsersDao);
    }

    public function add($entity){
        $entity['password'] = md5($entity['password']);
        return parent::add($entity);
    }

    public function registerUser($userData) {
        $userData['password'] = md5($userData['password']);
        return parent::add($userData);
    }

    public function getUserByEmail($email) {
        $user = parent::get_user_by_email_test($email);
        error_log("getUserByEmail: " . print_r($user, true));  // Log the user data
        return $user;
    }

    public function loginUser($email, $password) {
        $user = $this->getUserByEmail($email);
        error_log("loginUser - Retrieved user: " . print_r($user, true));  // Log the retrieved user
    
        if (!$user || !isset($user['ID'])) {  // Adjusting to check against the correct key
            error_log("loginUser - User not found or not correctly retrieved.");  // Log the error
            return null; // User not found
        }
    
        // Validate the password
        if (md5($password) === $user['Password']) {  // Adjusting to check against the correct key
            error_log("loginUser - Password match. User authenticated.");  // Log the success
            return $user; // Password matches, return user data
        }
    
        error_log("loginUser - Invalid credentials.");  // Log invalid credentials
        return null; // Invalid credentials
    }
}
?>
