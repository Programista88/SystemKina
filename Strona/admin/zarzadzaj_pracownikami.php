<?php
session_start();
require_once '../konfiguracja/config.php';

if (!isset($_SESSION['pracownik_id']) || $_SESSION['pracownik_stanowisko'] !== 'admin') {
    header('Location: panel_pracownika.php');
    exit();
}


$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function getEmployees($conn) {
    try {
        $sql = "SELECT pracownik_id, imie, nazwisko, email, stanowisko FROM pracownicy ORDER BY pracownik_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}
$employees = getEmployees($conn);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Zarządzaj Pracownikami - Alekino</title>
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
        <h1>Zarządzaj Pracownikami</h1>

        <div class="admin-menu">
            <a href="dodaj_pracownika.php" class="admin-tile">
                <i class="fas fa-user-plus"></i>
                <h3>Dodaj Pracownika</h3>
                <p>Dodaj nowego pracownika do systemu</p>
            </a>

            <a href="usun_pracownika.php" class="admin-tile">
                <i class="fas fa-user-minus"></i>
                <h3>Usuń Pracownika</h3>
                <p>Usuń pracownika z systemu</p>
            </a>

            <a href="edytuj_pracownika.php" class="admin-tile">
                <i class="fas fa-user-edit"></i>
                <h3>Edytuj Pracownika</h3>
                <p>Edytuj dane pracownika</p>
            </a>
        </div>

        <div class="employee-list">
            <h2>Lista Pracowników</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Email</th>
                        <th>Stanowisko</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?php echo $employee['pracownik_id']; ?></td>
                            <td><?php echo $employee['imie']; ?></td>
                            <td><?php echo $employee['nazwisko']; ?></td>
                            <td><?php echo $employee['email']; ?></td>
                            <td><?php echo $employee['stanowisko']; ?></td>
                           
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>