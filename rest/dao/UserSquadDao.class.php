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
        return $this->query(
            "SELECT * FROM " . $this->getTableName() . " WHERE user_id = :user_id",
            ['user_id' => $user_id]
        );
    }

    // The insert method and other methods inherited from BaseDao
}
