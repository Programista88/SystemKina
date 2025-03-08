function reserveTicket(filmId) {
    window.location.href = `proces_rezerw.php?film_id=${filmId}`;
}

function isUserLoggedIn() {
    return document.body.classList.contains('user-logged-in');
}

function loadSeats(seansId) {
    fetch(`get_siedzenia.php?seans_id=${seansId}`)
        .then(response => response.json())
        .then(data => {
            const seatMap = document.getElementById('seatMap');
            seatMap.innerHTML = '';
            let currentRow = 0;
            let rowDiv;

            data.forEach(seat => {
                if (currentRow !== seat.numer_rzedu) {
                    currentRow = seat.numer_rzedu;
                    rowDiv = document.createElement('div');
                    rowDiv.className = 'seat-row';
                    seatMap.appendChild(rowDiv);
                }

                const seatDiv = document.createElement('div');
                seatDiv.className = `seat ${seat.zajete ? 'occupied' : ''}`;
                seatDiv.textContent = `${seat.numer_rzedu}-${seat.numer_miejsca}`;
                seatDiv.dataset.miejsceId = seat.miejsce_id;

                if (!seat.zajete) {
                    seatDiv.addEventListener('click', function() {
                        document.querySelectorAll('.seat.selected').forEach(s => s.classList.remove('selected'));
                        this.classList.add('selected');
                        document.getElementById('miejsce_id').value = this.dataset.miejsceId;
                    });
                }

                rowDiv.appendChild(seatDiv);
            });
        });
}
