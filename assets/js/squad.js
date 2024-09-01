$(document).ready(function() {
    const selectedPlayers = new Set();

    // Fetch all players
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

    function renderPlayerList(players) {
        const playerList = $('#player-list');
        playerList.empty();

        players.forEach(player => {
            const playerCard = $(`
                <div class="player-card" data-player-id="${player.id}">
                    <h3>${player.name} ${player.surname}</h3>
                    <p>Position: ${player.position}</p>
                    <p>Age: ${player.age}</p>
                </div>
            `);
            playerCard.click(function() {
                togglePlayerSelection($(this), player.id);
            });
            playerList.append(playerCard);
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
