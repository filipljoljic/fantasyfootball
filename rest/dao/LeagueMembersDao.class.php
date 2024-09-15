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

    public function get_leagues_by_user($user_id) {
        return $this->query("SELECT l.* FROM leagues l JOIN league_members lm ON l.league_id = lm.league_id WHERE lm.user_id = :user_id", ['user_id' => $user_id]);
    }
    
    public function get_members_by_league($league_id) {
        // Update the SQL query to use the correct column name for the user ID
        return $this->query("SELECT u.* FROM users u JOIN league_members lm ON u.ID = lm.user_id WHERE lm.league_id = :league_id", ['league_id' => $league_id]);
    }

    public function get_user_leagues_with_members($user_id) {
        // Fetch leagues and members
        $query = "
            SELECT l.league_id, l.league_name, u.username, u.id as user_id, p.points_per_game
            FROM leagues l
            INNER JOIN league_members lm ON l.league_id = lm.league_id
            INNER JOIN users u ON lm.user_id = u.id
            INNER JOIN user_squad us ON u.id = us.user_id
            INNER JOIN players p ON us.player_id = p.id
            WHERE lm.league_id IN (SELECT league_id FROM league_members WHERE user_id = :user_id)";
        
        return $this->query($query, ['user_id' => $user_id]);
    }

}


?>