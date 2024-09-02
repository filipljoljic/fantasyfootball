$(document).ready(function() {
    const selectedPlayers = new Set();

    function renderPlayerList(players) {
        const playerList = $('#player-list');
        playerList.empty();

        players.forEach(player => {
            const playerCard = $(`
                <div class="player-card" data-player-id="${player.id}">
                    <h3>${player.name || 'Unknown'} ${player.surname || ''}</h3>
                    <p>Position: ${player.position || 'N/A'}</p>
                    <p>Team: ${player.team || 'N/A'}</p>
                    <p>Points: ${player.total_points || 0}</p>
                    <p>Age: ${player.age || 'N/A'}</p>
                </div>
            `);

            playerCard.click(function() {
                togglePlayerSelection($(this), player.id);
            });

            playerList.append(playerCard);
        });

        displayTotalPoints(players); // Update total points after rendering the list
    }

    function fetchAndDisplayAllPlayers() {
        $.ajax({
            url: 'rest/players',
            type: 'GET',
            dataType: 'json',
            success: function(players) {
                renderPlayerList(players);
            },
            error: function(err) {
                toastr.error('Failed to load players.');
                console.error(err);
            }
        });
    }

    function togglePlayerSelection(card, playerId) {
        if (selectedPlayers.has(playerId)) {
            selectedPlayers.delete(playerId);
            card.removeClass('selected');
        } else {
            if (selectedPlayers.size >= 11) {
                toastr.warning('You can only select 11 players.');
                return;
            }
            selectedPlayers.add(playerId);
            card.addClass('selected');
        }
        updateSaveButton();
    }

    function updateSaveButton() {
        $('#save-squad').prop('disabled', selectedPlayers.size !== 11);
    }

    function displayTotalPoints(players) {
        let totalPoints = 0;

        players.forEach(player => {
            const points = parseInt(player.total_points, 10);
            if (!isNaN(points)) {
                totalPoints += points;
            } else {
                console.error(`Invalid points for player ${player.name}:`, player.total_points);
            }
        });

        console.log("Calculated Total Points:", totalPoints); // Debugging log
        $('#total-points').text(totalPoints); // Update the total points in the UI
    }

    // Fetch the selected players for the user from the server
    $.ajax({
        url: 'rest/user_selected_squad',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response); // Log the response to see the structure
            if (response.message === 'No players selected yet.') {
                fetchAndDisplayAllPlayers();
            } else {
                renderPlayerList(response);
            }
        },
        error: function(err) {
            toastr.error('Failed to load your selected squad.');
            console.error(err);
        }
    });

    $('#save-squad').click(function() {
        const playerIds = Array.from(selectedPlayers);
        $.ajax({
            url: 'rest/user_squad',
            type: 'POST',
            contentType: 'application/json',
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
});
