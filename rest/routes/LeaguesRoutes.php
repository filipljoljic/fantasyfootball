<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

Flight::route("GET /leagues", function(){
    Flight::json($result = Flight::leagues_service()->get_all());
});

Flight::route('POST /leagues/create', function() {

    // Check if the user is authenticated
    if (!isset($_SESSION['user_id'])) {
        Flight::json(['message' => 'User not authenticated.'], 401);
        return;
    }

    // Retrieve the logged-in user's ID
    $userId = $_SESSION['user_id'];
    $data = Flight::request()->data->getData();

    // Ensure league name is provided
    if (!isset($data['league_name'])) {
        Flight::json(['message' => 'League name is required.'], 400);
        return;
    }

    // Create the league using the service, setting the creator_id to the logged-in user
    $league = Flight::leagues_service()->createLeague([
        'league_name' => $data['league_name'],
        'creator_id' => $userId  // Creator ID is the logged-in user
    ]);

    // Check if the league was successfully created and return the result
    if ($league) {
        Flight::json(['message' => 'League created successfully', 'league' => $league]);
    } else {
        Flight::json(['message' => 'Failed to create the league'], 400);
    }
});


?>