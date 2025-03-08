<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
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
    WHERE r.rezerwacja_id = ? AND r.klient_id = ? AND r.status = 'aktywna'
");
$stmt->execute([$_GET['id'], $_SESSION['user_id']]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    header('Location: rezerwacje.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Kod QR biletu - <?php echo htmlspecialchars($reservation['tytul']); ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="images/png" sizes="64x64" href="zdjecia/logo/logo.png">
</head>

<body class="qr-page">
    <div class="qr-container">
        <div class="ticket-info">
            <h2><?php echo htmlspecialchars($reservation['tytul']); ?></h2>
            <p>Sala: <?php echo htmlspecialchars($reservation['nazwa_sali']); ?></p>
            <p>Data: <?php echo date('d.m.Y H:i', strtotime($reservation['data_seansu'])); ?></p>
            <p>Miejsce: Rząd <?php echo $reservation['numer_rzedu']; ?>, Miejsce
                <?php echo $reservation['numer_miejsca']; ?></p>
        </div>

        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?php
            echo urlencode("Bilet: " . $reservation['rezerwacja_id'] .
                "\nFilm: " . $reservation['tytul'] .
                "\nSala: " . $reservation['nazwa_sali'] .
                "\nData: " . date('d.m.Y H:i', strtotime($reservation['data_seansu'])) .
                "\nMiejsce: Rząd " . $reservation['numer_rzedu'] . ", Miejsce " . $reservation['numer_miejsca']);
            ?>" alt="Kod QR biletu">
        </div>
        <a href="rezerwacje.php" class="return-btn">
            <i class="fas fa-arrow-left"></i> Powrót do moich rezerwacji
        </a>
    </div>
</body>

</html>