<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$stmt = $db->prepare("SELECT * FROM klienci WHERE klient_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje Konto - Alekino</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="images/png" sizes="64x64" href="zdjecia/logo/logo.png">
</head>
<body>
    <main class="account-container">
        <h2>Moje Konto</h2>
        <div class="user-info">
            <p><strong>Imię:</strong> <?php echo htmlspecialchars($user['imie']); ?></p>
            <p><strong>Nazwisko:</strong> <?php echo htmlspecialchars($user['nazwisko']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Telefon:</strong> <?php echo htmlspecialchars($user['telefon']); ?></p>
        </div>
        <a href="wylogowanie.php" class="logout-btn">Wyloguj się</a>
    </main>
</body>
</html>
