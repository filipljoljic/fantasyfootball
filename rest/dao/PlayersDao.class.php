<?php
require_once "BaseDao.class.php";

class PlayersDao extends BaseDao{

    public function __construct(){
        parent::__construct("players"); 
    }

}


?>