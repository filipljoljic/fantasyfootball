<?php
require_once 'BaseService.php';
require_once __DIR__."/../dao/PlayersDao.class.php";

class PlayersService extends BaseService{
    public function __construct(){
        parent::__construct(new PlayersDao);
    }

    public function add($entity){
        parent::add($entity);
        //send email
    }
}


?>