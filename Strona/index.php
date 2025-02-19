<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kino - Rezerwacja Biletów - Filmy 3D</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" type="images/png" sizes="64x64" href="zdjecia/logo/logo.png">

</head>

<body>
    <header>
        <div class="logo-container">
            <img src="zdjecia/logo/logo.png" alt="Alekino Logo">
            <h1>Alekino!</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Strona główna</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="konto.php">Konto</a></li>
                    <li><a href="logout.php" class="logout-btn">Wyloguj</a></li>
                <?php else: ?>
                    <li><a href="login.php">Logowanie</a></li>
                    <li><a href="rejestracja.php">Rejestracja</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>


    <main>
        <h2>Aktualne Filmy</h2>
        <div class="movies">
            <?php
            $stmt = $db->query("SELECT * FROM filmy WHERE data_premiery <= CURRENT_DATE ORDER BY data_premiery DESC");
            while ($film = $stmt->fetch(mode: PDO::FETCH_ASSOC)) {
                echo '<div class="movie">';
                echo '<img src="zdjecia/filmy/film_' . htmlspecialchars(string: $film['film_id']) . '.jpg" alt="' . htmlspecialchars(string: $film['tytul']) . '">';
                echo '<h3>' . htmlspecialchars(string: $film['tytul']) . '</h3>';
                echo '<p>' . htmlspecialchars(string: $film['opis']) . '</p>';
                echo '<button onclick="reserveTicket(' . $film['film_id'] . ')">Kup Bilet</button>';
                echo '</div>';
            }
            ?>
        </div>
    </main>

    <footer>
        <footer>
            <div class="footer-content">
                <div class="footer-section">
                    <h3>O nas</h3>
                    <p>Alekino to nowoczesne kino oferujące najnowsze filmy w najwyższej jakości. Zapraszamy do świata
                        magii kina!</p>
                </div>

                <div class="footer-section">
                    <h3>Kontakt</h3>
                    <p>
                        Email: kontakt@alekino.pl<br>
                        Tel: +48 123 456 789<br>
                        Adres: ul. Filmowa 1<br>
                        00-000 Warszawa
                    </p>
                </div>

                <div class="footer-section">
                    <h3>Social Media</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 Alekino! Wszystkie prawa zastrzeżone.</p>
            </div>
        </footer>

    </footer>

    <script src="script.js"></script>
</body>

</html>