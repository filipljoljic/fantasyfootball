<?php
require_once 'BaseService.php';
require_once __DIR__."/../dao/LeaguesDao.class.php";

class LeaguesService extends BaseService{
    public function __construct(){
        parent::__construct(new LeaguesDao);
    }
    
    public function createLeague($leagueData) {
        return $this->add($leagueData);  
    }

}


?>