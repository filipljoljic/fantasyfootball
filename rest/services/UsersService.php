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
}


?>