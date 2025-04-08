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
                <li><a href="../index.php">Strona główna</a></li>
                <li><a href="panel_pracownika.php">Panel Pracownika</a></li>
                <li><a href="konto_pracownika.php">Konto (Pracownik)</a></li>
            </ul>
        </nav>
    </header>

    <main class="employee-account-container">
        <div class="employee-account-header">
            <i class="fas fa-user-tie"></i>
            <h2>Konto Pracownika</h2>
            <p>Witaj, <?php echo $pracownik['imie'] . ' ' . $pracownik['nazwisko']; ?></p>
            <span class="employee-role-badge <?php echo strtolower($pracownik['stanowisko']); ?>">
                <?php echo ucfirst($pracownik['stanowisko']); ?>
            </span>
        </div>

        <div class="employee-data-container">
            <div class="employee-data-box">
                <div class="employee-data-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="employee-data-content">
                    <h3>Email</h3>
                    <p><?php echo $pracownik['email']; ?></p>
                </div>
            </div>

            <div class="employee-data-box">
                <div class="employee-data-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="employee-data-content">
                    <h3>Telefon</h3>
                    <p><?php echo $pracownik['telefon'] ?? 'Nie podano'; ?></p>
                </div>
            </div>

            <div class="employee-data-box">
                <div class="employee-data-icon">
                    <i class="fas fa-id-badge"></i>
                </div>
                <div class="employee-data-content">
                    <h3>Stanowisko</h3>
                    <p><?php echo ucfirst($pracownik['stanowisko']); ?></p>
                </div>
            </div>

            <div class="employee-data-box">
                <div class="employee-data-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="employee-data-content">
                    <h3>Data Zatrudnienia</h3>
                    <p><?php echo date('d.m.Y', strtotime($pracownik['data_zatrudnienia'])); ?></p>
                </div>
            </div>
        </div>

        <div class="employee-account-actions">
            <a href="../autoryzacja/logout.php" class="employee-action-btn secondary">
                <i class="fas fa-sign-out-alt"></i> Wyloguj się
            </a>
        </div>
    </main>
</body>

</html>