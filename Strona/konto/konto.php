<?php
session_start();
require_once '../konfiguracja/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../autoryzacja/login.php');
    exit();
}

$stmt = $db->prepare("SELECT * FROM klienci WHERE klient_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<?php if (isset($_SESSION['message'])): ?>
    <div class="message <?php echo $_SESSION['message_type']; ?>">
        <?php 
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        ?>
    </div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje Konto - Alekino</title>
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
                <li><a href="../autoryzacja/logout.php" class="logout-btn">Wyloguj</a></li>
            </ul>
        </nav>
    </header>

    <main class="account-container">
        <div class="account-header">
            <i class="fas fa-user-circle profile-icon"></i>
            <h2>Moje Konto</h2>
        </div>

        <div class="user-data-container">
            <div class="data-box">
                <div class="data-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="data-content">
                    <h3>Imię i Nazwisko</h3>
                    <p><?php echo htmlspecialchars($user['imie'] . ' ' . $user['nazwisko']); ?></p>
                </div>
            </div>

            <div class="data-box">
                <div class="data-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="data-content">
                    <h3>Email</h3>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>

            <div class="data-box">
                <div class="data-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="data-content">
                    <h3>Telefon</h3>
                    <p><?php echo htmlspecialchars($user['telefon']); ?></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
