<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $film_id = $_POST['film_id'] ?? null;
    $user_id = $_SESSION['user_id'];

    if ($film_id) {
        try {
            $stmt = $db->prepare("SELECT seans_id FROM seanse WHERE film_id = ? AND data_seansu > NOW() LIMIT 1");
            $stmt->execute([$film_id]);
            $seans = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($seans) {
                $stmt = $db->prepare("INSERT INTO rezerwacje (klient_id, seans_id, data_rezerwacji, status) VALUES (?, ?, NOW(), 'aktywna')");
                if ($stmt->execute([$user_id, $seans['seans_id']])) {
                    echo json_encode(['success' => true]);
                    exit();
                }
            }
            echo json_encode(['success' => false, 'message' => 'Brak dostępnych seansów']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Błąd podczas rezerwacji']);
        }
    }
    exit();
}

$stmt = $db->prepare("
    SELECT r.*, f.tytul, s.data_seansu 
    FROM rezerwacje r 
    JOIN seanse s ON r.seans_id = s.seans_id 
    JOIN filmy f ON s.film_id = f.film_id 
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
                        <p>Data seansu: <?php echo date('d.m.Y H:i', strtotime($reservation['data_seansu'])); ?></p>
                        <p>Status: <?php echo htmlspecialchars($reservation['status']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>