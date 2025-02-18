function reserveTicket(filmId) {
    fetch('reserve.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `film_id=${filmId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Rezerwacja została przyjęta!');
        } else {
            alert('Wystąpił błąd podczas rezerwacji.');
        }
    })
    .catch(error => {
        console.error('Błąd:', error);
        alert('Wystąpił błąd podczas rezerwacji.');
    });
}
