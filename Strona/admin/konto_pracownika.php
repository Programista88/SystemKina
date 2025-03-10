<?php
session_start();
require_once '../konfiguracja/config.php';

if (!isset($_SESSION['pracownik_id'])) {
    header('Location: login.php');
    exit();
}

$stmt = $db->prepare("SELECT * FROM pracownicy WHERE pracownik_id = ?");
$stmt->execute([$_SESSION['pracownik_id']]);
$pracownik = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Konto Pracownika - Alekino</title>
    <link rel="stylesheet" href="../zasoby/css/style.css">
    <link rel="icon" type="images/png" sizes="64x64" href="zdjecia/logo/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="../zdjecia/logo/logo.png" alt="Alekino Logo">
            <h1>Alekino!</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Strona główna</a></li>
                <li><a href="panel_pracownika.php">Panel Pracownika</a></li>
                <li><a href="konto_pracownika.php">Konto (Pracownik)</a></li>
                <li><a href="autoryzacja/logout.php" class="logout-btn">Wyloguj</a></li>
            </ul>
        </nav>
    </header>

    <main class="account-container">
        <div class="account-header">
            <i class="fas fa-user-circle profile-icon"></i>
            <h2>Konto Pracownika</h2>
        </div>

        <div class="user-data-container">
            <div class="data-box">
                <div class="data-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="data-content">
                    <h3>Imię i Nazwisko</h3>
                    <p><?php echo htmlspecialchars($pracownik['imie'] . ' ' . $pracownik['nazwisko']); ?></p>
                </div>
            </div>

            <div class="data-box">
                <div class="data-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="data-content">
                    <h3>Email</h3>
                    <p><?php echo htmlspecialchars($pracownik['email']); ?></p>
                </div>
            </div>

            <div class="data-box">
                <div class="data-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="data-content">
                    <h3>Stanowisko</h3>
                    <p><?php echo htmlspecialchars($pracownik['stanowisko']); ?></p>
                </div>
            </div>

            <div class="data-box">
                <div class="data-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="data-content">
                    <h3>Data Zatrudnienia</h3>
                    <p><?php echo date('d.m.Y', strtotime($pracownik['data_zatrudnienia'])); ?></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
