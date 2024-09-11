<?php
require_once "BaseDao.class.php";

class LeagueMembersDao extends BaseDao{

    public function __construct(){
        parent::__construct("league_members"); 
    }

    public function get_by_user_and_league($user_id, $league_id) {
        return $this->query("SELECT * FROM league_members WHERE user_id = :user_id AND league_id = :league_id", [
            'user_id' => $user_id,
            'league_id' => $league_id
        ]);
    }

}


?>