$(document).ready(function() {
    const selectedPlayers = new Set();  // Track selected players
    let allPlayers = [];  // Store all player data

    // Function to render player list as clickable cards
    function renderPlayerList(players) {
        const playersContainer = $('#player-list');  // Target the #player-list div
        playersContainer.empty();  // Clear any existing content
    
        // Loop through each player and display their data
        players.forEach(function (player) {
            let points = {};

            // Try parsing the points_per_game field
            try {
                points = JSON.parse(player.points_per_game);
            } catch (error) {
                console.error(`Invalid points for player ${player.name}: ${error.message}`);
            }
    
            // Calculate total points for the player
            let totalPoints = 0;
            for (const game in points) {
                if (points.hasOwnProperty(game)) {
                    totalPoints += points[game];  // Sum the points for each game
                }
            }

            // Create the player card HTML
            const playerHtml = `
                <div class="player-card" data-player-id="${player.id}" data-total-points="${totalPoints}">
                    <h5>${player.name} ${player.surname}</h5>
                    <p>Position: ${player.position}</p>
                    <p>Team: ${player.team}</p>
                    <p>Total Points: ${totalPoints}</p>
                </div>
            `;
            playersContainer.append(playerHtml);  // Append the player card to the container
        });

        // Attach click events to each player card
        $('.player-card').on('click', function() {
            const playerId = $(this).data('player-id');  // Get player ID from data attribute
            const totalPoints = $(this).data('total-points');  // Get total points from data attribute
            togglePlayerSelection($(this), playerId, totalPoints);  // Pass the card and player ID to the toggle function
        });
    }

    // Function to toggle player selection
    function togglePlayerSelection(card, playerId, totalPoints) {
        if (selectedPlayers.has(playerId)) {
            selectedPlayers.delete(playerId);  // Deselect player
            card.removeClass('selected');
        } else {
            if (selectedPlayers.size >= 11) {
                toastr.warning('You can only select 11 players.');
                return;
            }
            selectedPlayers.add(playerId);  // Select player
            card.addClass('selected');
        }

        // Update the total points and the save button state
        updateSaveButton();
        displayTotalPoints();
    }

    // Function to update the "Save Squad" button state
    function updateSaveButton() {
        $('#save-squad').prop('disabled', selectedPlayers.size !== 11);
    }

    // Function to display total points in the UI for the selected players
    function displayTotalPoints() {
        let totalPoints = 0;

        // Loop through each selected player and sum their points
        selectedPlayers.forEach(playerId => {
            const playerCard = $(`[data-player-id="${playerId}"]`);  // Find the player's card
            const points = playerCard.data('total-points');  // Get the player's total points
            totalPoints += points;  // Add to the total points
        });

        console.log("Calculated Total Points:", totalPoints);  // Debugging log
        $('#total-points').text(totalPoints);  // Update the total points in the UI
    }

    // Fetch the players when the page loads and render the list
    $.ajax({
        url: 'rest/players',  // Adjust the URL to match your backend endpoint
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            allPlayers = response;  // Store all players
            renderPlayerList(response);  // Render the players in the list
        },
        error: function(err) {
            toastr.error('Failed to load players.');
            console.error(err);
        }
    });

    // When the user clicks "Save Squad"
    $('#save-squad').click(function() {
        const playerIds = Array.from(selectedPlayers);  // Convert the Set to an array

        // Get the JWT token from localStorage
        const token = localStorage.getItem('user_token');
        
        $.ajax({
            url: 'rest/user_squad',
            type: 'POST',
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + token  // Include the JWT token in the Authorization header
            },
            data: JSON.stringify({ player_ids: playerIds }),
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(err) {
                toastr.error('Failed to save squad.');
                console.error(err);
            }
        });
    });

    // Fetch the user's selected squad when the page loads
    $.ajax({
        url: 'rest/user_selected_squad',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.length > 0) {
                renderPlayerList(response);  // Render only the selected squad players
            } else {
                toastr.info('No players selected yet.');
            }
        },
        error: function(err) {
            toastr.error('Failed to load your selected squad.');
            console.error(err);
        }
    });
});