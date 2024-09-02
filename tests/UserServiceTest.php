<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../rest/services/UsersService.php';
require_once __DIR__ . '/../rest/dao/UsersDao.class.php';

class UserServiceTest extends TestCase {

    private $userService;

    protected function setUp(): void {
        $this->userService = new UsersService(new UsersDao());
    }

    public function testRegisterUser() {
        $user_data = [
            'username' => 'testuser',
            'password' => 'password123',
            'email' => 'testuser@example.com'
        ];

        $result = $this->userService->registerUser($user_data);

        $this->assertIsArray($result);
        $this->assertEquals($user_data['username'], $result['username']);
        $this->assertEquals($user_data['email'], $result['email']);
        $this->assertArrayHasKey('id', $result);
    }

    public function testLoginUserSuccess() {
        $email = 'testuser@example.com';
        $password = 'password123'; // Original plain password before MD5 hashing
    
        $result = $this->userService->loginUser($email, $password);
    
        // Check if the result is an array and contains expected data
        $this->assertIsArray($result);
        $this->assertEquals('testuser', $result['Username']);
        $this->assertEquals($email, $result['Email']);
        $this->assertArrayHasKey('ID', $result);
    }

    public function testLoginUserFailure() {
        $email = 'testuser@example.com';
        $password = 'wrongpassword';

        $result = $this->userService->loginUser($email, $password);

        $this->assertNull($result);
    }
}

