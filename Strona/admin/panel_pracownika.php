<?php
session_start();
require_once '../konfiguracja/config.php';

if (!isset($_SESSION['pracownik_id'])) {
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Panel Pracownika - Alekino</title>
    <link rel="stylesheet" href="../zasoby/css/style.css">
    <link rel="icon" type="images/png" sizes="64x64" href="../zdjecia/logo/logo.png">
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
                <?php if (isset($_SESSION['pracownik_id'])): ?>
                    <li><a href="konto_pracownika.php">Konto (Pracownik)</a></li>
                    <li><a href="../autoryzacja/logout.php" class="logout-btn">Wyloguj</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="admin-panel">
        <h1>Panel Pracownika</h1>

        <div class="admin-menu">
            <a href="zarzadzaj_filmami.php" class="admin-tile">
                <i class="fas fa-film"></i>
                <h3>Zarządzaj Filmami</h3>
                <p>Dodaj, edytuj lub usuń filmy</p>
            </a>

            <a href="zarzadzaj_seansami.php" class="admin-tile">
                <i class="fas fa-clock"></i>
                <h3>Zarządzaj Seansami</h3>
                <p>Planuj seanse filmowe</p>
            </a>

            <a href="wszystkie_rezerwacje.php" class="admin-tile">
                <i class="fas fa-ticket-alt"></i>
                <h3>Rezerwacje</h3>
                <p>Przeglądaj wszystkie rezerwacje</p>
            </a>

            <a href="raporty.php" class="admin-tile">
                <i class="fas fa-chart-bar"></i>
                <h3>Raporty</h3>
                <p>Generuj raporty sprzedaży</p>
            </a>
            <?php if ($_SESSION['pracownik_stanowisko'] === 'admin'): ?>
                <a href="zarzadzaj_pracownikami.php" class="admin-tile">
                    <i class="fas fa-users-cog"></i>
                    <h3>Zarządzaj Pracownikami</h3>
                    <p>Zatrudniaj i zwalniaj pracowników</p>
                </a>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>