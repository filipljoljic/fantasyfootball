<?php
class UserSquadDao extends BaseDao {

    public function __construct(){
        parent::__construct("user_squad");
    }

    public function add_to_squad($user_id, $player_id) {
        return $this->insert([
            'user_id' => $user_id,
            'player_id' => $player_id
        ]);
    }

    public function get_squad_by_user_id($user_id) {
        $players = $this->query(
            "SELECT p.id, p.name, p.surname, p.position, p.age, p.team, p.points_per_game
            FROM user_squad us
            JOIN players p ON us.player_id = p.id
            WHERE us.user_id = :user_id",
            ['user_id' => $user_id]
        );
    
        // Process the results in PHP to calculate the total points
        foreach ($players as &$player) {
            $pointsArray = json_decode($player['points_per_game'], true);
            $player['total_points'] = array_sum($pointsArray);
        }
    
        return $players;
    }


    // The insert method and other methods inherited from BaseDao
}
