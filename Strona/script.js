function reserveTicket(filmId) {
    window.location.href = `proces_rezerw.php?film_id=${filmId}`;
}

function isUserLoggedIn() {
    return document.body.classList.contains('user-logged-in');
}
