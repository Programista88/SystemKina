<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


$stmt = $db->prepare("
    SELECT r.*, f.tytul, s.data_seansu, m.numer_rzedu, m.numer_miejsca, sa.nazwa_sali
    FROM rezerwacje r 
    JOIN seanse s ON r.seans_id = s.seans_id 
    JOIN filmy f ON s.film_id = f.film_id 
    JOIN miejsca m ON r.miejsce_id = m.miejsce_id
    JOIN sale sa ON s.sala_id = sa.sala_id
    WHERE r.klient_id = ?
    ORDER BY r.data_rezerwacji DESC
");
$stmt->execute([$_SESSION['user_id']]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Moje Rezerwacje - Alekino</title>
    <link rel="stylesheet" href="style.css">
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
                <li><a href="rezerwacje.php">Moje Rezerwacje</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="konto.php">Konto</a></li>
                    <li><a href="wylogowanie.php" class="logout-btn">Wyloguj</a></li>
                <?php else: ?>
                    <li><a href="login.php">Konto/Logowanie</a></li>
                    <li><a href="rejestracja.php">Rejestracja</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="reservations-container">
        <h2>Moje Rezerwacje</h2>

        <?php if (empty($reservations)): ?>
            <p class="no-reservations">Nie masz jeszcze żadnych rezerwacji.</p>
        <?php else: ?>
            <div class="reservations-list">
                <?php foreach ($reservations as $reservation): ?>
                    <div class="reservation-card">
                        <h3><?php echo htmlspecialchars($reservation['tytul']); ?></h3>
                        <p>
                            <strong>Data seansu:</strong><br>
                            <?php echo date('d.m.Y H:i', strtotime($reservation['data_seansu'])); ?>
                        </p>
                        <p>
                            <strong>Sala:</strong><br>
                            <?php echo htmlspecialchars($reservation['nazwa_sali']); ?>
                        </p>
                        <p>
                            <strong>Miejsce:</strong><br>
                            Rząd <?php echo $reservation['numer_rzedu']; ?>,
                            Miejsce <?php echo $reservation['numer_miejsca']; ?>
                        </p>
                        <p>
                            <strong>Data rezerwacji:</strong><br>
                            <?php echo date('d.m.Y H:i', strtotime($reservation['data_rezerwacji'])); ?>
                        </p>
                        <p>
                            <strong>Status:</strong><br>
                            <span class="status <?php echo strtolower($reservation['status']); ?>">
                                <?php echo htmlspecialchars($reservation['status']); ?>
                            </span>
                        </p>
                        <?php if ($reservation['status'] !== 'anulowana'): ?>
                            <a href="anuluj_rezerwacje.php?id=<?php echo $reservation['rezerwacja_id']; ?>" class="cancel-btn"
                                onclick="return confirm('Czy na pewno chcesz anulować tę rezerwację?')">
                                Anuluj rezerwację
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>