<?php
session_start();

// Route to get the current user's squad
Flight::route("GET /user_squad", function() {
    if (!isset($_SESSION['user_id'])) {
        Flight::json(['message' => 'User not authenticated.'], 401);
        return;
    }
    
    Flight::json(Flight::user_squad_service()->get_all());
});

// Route to save the current user's squad
Flight::route("POST /user_squad", function() {
    if (!isset($_SESSION['user_id'])) {
        Flight::json(['message' => 'User not authenticated.'], 401);
        return;
    }

    $user_id = $_SESSION['user_id'];
    $data = Flight::request()->data->getData();
    $player_ids = $data['player_ids'] ?? null;

    if (!$player_ids || count($player_ids) !== 11) {
        Flight::json(['message' => 'Exactly 11 players must be selected.'], 400);
        return;
    }

    $result = Flight::user_squad_service()->save_user_squad($user_id, $player_ids);

    if ($result) {
        Flight::json(['message' => 'Squad saved successfully.']);
    } else {
        Flight::json(['message' => 'You have already selected your squad and cannot modify it.'], 403);
    }
});

Flight::route("GET /user_selected_squad", function() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $user_id = $_SESSION['user_id'] ?? null;
    
    if (!$user_id) {
        Flight::json(['message' => 'User not authenticated.'], 401);
        return;
    }

    $selected_squad = Flight::user_squad_service()->get_squad_by_user_id($user_id);

    // Check if the user has selected any players
    if (empty($selected_squad)) {
        Flight::json(['message' => 'No players selected yet.'], 200);
    } else {
        Flight::json($selected_squad);
    }
});


?>
