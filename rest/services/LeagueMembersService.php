<?php
require_once 'BaseService.php';
require_once __DIR__."/../dao/LeagueMembersDao.class.php";

class LeagueMembersService extends BaseService{
    public function __construct(){
        $this->dao = new LeagueMembersDao(); // Instantiate the DAO here
        parent::__construct($this->dao);  // Pass it to the parent constructor
    }


        // Join the league (add a record if not already a member)
    public function join_league($user_id, $league_id) {
        // Check if the user is already in the league
        $existing_member = $this->dao->get_by_user_and_league($user_id, $league_id);
        if (!empty($existing_member)) {
            return ['status' => 'error', 'message' => 'User already joined this league.'];
        }

        // Add the user to the league
        $data = [
            'league_id' => $league_id,
            'user_id' => $user_id,
            'joined_at' => date('Y-m-d H:i:s')
        ];

        return $this->dao->add($data);
    }
    
}


?>