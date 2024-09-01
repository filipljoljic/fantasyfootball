<?php
require_once 'BaseService.php';
require_once __DIR__."/../dao/UserSquadDao.class.php";

class UserSquadService extends BaseService {
    private $dao;

    public function __construct() {
        $this->dao = new UserSquadDao(); // Initialize the $dao property
        parent::__construct($this->dao); // Pass the dao to the parent class constructor if necessary
    }

    public function save_user_squad($user_id, $player_ids) {
        error_log("Player IDs: " . implode(",", $player_ids));
        error_log("User ID: " . $user_id);

        // Check if the user has already selected a squad
        $existing_squad = $this->dao->get_squad_by_user_id($user_id);

        if (count($existing_squad) > 0) {
            return false;
        }

        foreach ($player_ids as $player_id) {
            $result = $this->dao->add_to_squad($user_id, $player_id);
            if ($result === false) {
                error_log("Database Error: " . $this->dao->get_error());
                return false;
            }
        }

        return true;
    }
}
?>
