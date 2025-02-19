function reserveTicket(filmId) {
    fetch('rezerwacje.php', {
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
            window.location.href = 'rezerwacje.php';
        } else {
            alert(data.message || 'Wystąpił błąd podczas rezerwacji.');
        }
    })
    .catch(error => {
        console.error('Błąd:', error);
        alert('Wystąpił błąd podczas rezerwacji.');
    });
}


function isUserLoggedIn() {
    return document.body.classList.contains('user-logged-in');
}
