<?php
require_once 'BaseService.php';
require_once __DIR__."/../dao/LeagueMembersDao.class.php";

class LeagueMembersService extends BaseService{
    private $dao;  // Explicitly declare the property

    public function __construct() {
        $this->dao = new LeagueMembersDao();  // Instantiate the DAO here
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

    public function get_user_leagues_with_members($user_id) {
        return $this->dao->get_user_leagues_with_members($user_id);
    }

    // Format league members and calculate points
    public function format_league_members_with_points($members) {
        $result = [];
        $user_points_map = [];
    
        // Loop through each member
        foreach ($members as $member) {
            $username = $member['username'];
            $league_name = $member['league_name'];
            $points_data = json_decode($member['points_per_game'], true); // decode JSON points_per_game
    
            // Initialize total points for user in the league if not already processed
            if (!isset($user_points_map[$league_name][$username])) {
                $user_points_map[$league_name][$username] = 0;
            }
    
            // Check if points_data is a valid JSON and is an array
            if (is_array($points_data)) {
                // Log the points data
                error_log("Points data for $username in league $league_name: " . json_encode($points_data));
    
                // Loop through each game points and add them
                foreach ($points_data as $game => $points) {
                    if (is_numeric($points)) {
                        $user_points_map[$league_name][$username] += $points;
                    } else {
                        // Log if points are missing or invalid
                        error_log("Invalid or missing points for $username in $league_name, game: $game");
                    }
                }
            } else {
                // Log error if points_data is not a valid array
                error_log("Invalid points_per_game data for user $username in league $league_name: " . json_encode($member['points_per_game']));
            }
    
            // Log points progress
            error_log("User: $username, League: $league_name, Points so far: " . $user_points_map[$league_name][$username]);
        }
    
        // Format the result for output
        foreach ($user_points_map as $league_name => $users) {
            foreach ($users as $username => $total_points) {
                if (!isset($result[$league_name])) {
                    $result[$league_name] = [];
                }
    
                // Add user and their total points to the result
                $result[$league_name][] = [
                    'username' => $username,
                    'total_points' => $total_points
                ];
    
                // Log final points
                error_log("Final Total Points for $username in league $league_name: $total_points");
            }
        }
    
        return $result; // Return the formatted result
    }
}

    



?>