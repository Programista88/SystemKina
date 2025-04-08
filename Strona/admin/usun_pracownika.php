<?php
session_start();
require_once '../konfiguracja/config.php';

// Sprawdzenie czy użytkownik jest zalogowany jako admin
if (!isset($_SESSION['pracownik_id']) || $_SESSION['pracownik_stanowisko'] !== 'admin') {
    header('Location: panel_pracownika.php');
    exit();
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
$messageType = '';
$pracownicy = [];

// Pobieranie listy pracowników
$query = "SELECT pracownik_id, imie, nazwisko, email, stanowisko FROM pracownicy ORDER BY nazwisko, imie";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pracownicy[] = $row;
    }
}

// Obsługa usuwania pracownika
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usun_pracownika'])) {
    $pracownik_id = $_POST['pracownik_id'];

    // Sprawdzenie czy pracownik nie usuwa sam siebie
    if ($pracownik_id == $_SESSION['pracownik_id']) {
        $message = 'Nie możesz usunąć swojego własnego konta!';
        $messageType = 'error';
    } else {
        // Usuwanie pracownika
        $stmt = $conn->prepare("DELETE FROM pracownicy WHERE pracownik_id = ?");
        $stmt->bind_param("i", $pracownik_id);

        if ($stmt->execute()) {
            $message = 'Pracownik został pomyślnie usunięty!';
            $messageType = 'success';

            // Odświeżenie listy pracowników
            $result = $conn->query("SELECT pracownik_id, imie, nazwisko, email, stanowisko FROM pracownicy ORDER BY nazwisko, imie");
            $pracownicy = [];

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $pracownicy[] = $row;
                }
            }
        } else {
            $message = 'Wystąpił błąd podczas usuwania pracownika: ' . $conn->error;
            $messageType = 'error';
        }
    }
}

// Obsługa potwierdzenia usunięcia pracownika
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['potwierdz_usuniecie'])) {
    $pracownik_id = $_POST['pracownik_id'];

    // Pobieranie danych pracownika do potwierdzenia
    $stmt = $conn->prepare("SELECT pracownik_id, imie, nazwisko, email, stanowisko FROM pracownicy WHERE pracownik_id = ?");
    $stmt->bind_param("i", $pracownik_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $pracownik_do_usuniecia = $result->fetch_assoc();
    } else {
        $message = 'Nie znaleziono pracownika o podanym ID!';
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Usuń Pracownika - Alekino</title>
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
        <h1>Usuń Pracownika</h1>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="admin-form" style="background: linear-gradient(to bottom, #f8f9fa, #e9ecef); max-width: 95%;">
            <?php if (isset($pracownik_do_usuniecia)): ?>
                <div class="account-container">
                    <div class="account-header">
                        <i class="fas fa-exclamation-triangle profile-icon" style="color: #dc3545;"></i>
                        <h2>Potwierdzenie usunięcia</h2>
                    </div>

                    <p>Czy na pewno chcesz usunąć tego pracownika? Ta operacja jest nieodwracalna.</p>

                    <div class="user-data-container">
                        <div class="data-box">
                            <div class="data-icon">
                                <i class="fas fa-id-badge"></i>
                            </div>
                            <div class="data-content">
                                <h3>ID</h3>
                                <p><?php echo $pracownik_do_usuniecia['pracownik_id']; ?></p>
                            </div>
                        </div>

                        <div class="data-box">
                            <div class="data-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="data-content">
                                <h3>Imię i nazwisko</h3>
                                <p><?php echo htmlspecialchars($pracownik_do_usuniecia['imie'] . ' ' . $pracownik_do_usuniecia['nazwisko']); ?>
                                </p>
                            </div>
                        </div>

                        <div class="data-box">
                            <div class="data-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="data-content">
                                <h3>Email</h3>
                                <p><?php echo htmlspecialchars($pracownik_do_usuniecia['email']); ?></p>
                            </div>
                        </div>

                        <div class="data-box">
                            <div class="data-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="data-content">
                                <h3>Stanowisko</h3>
                                <p><?php echo htmlspecialchars($pracownik_do_usuniecia['stanowisko']); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="account-actions">
                        <form method="POST" action="">
                            <input type="hidden" name="pracownik_id"
                                value="<?php echo $pracownik_do_usuniecia['pracownik_id']; ?>">
                            <button type="submit" name="usun_pracownika" class="cancel-btn">
                                <i class="fas fa-trash-alt"></i> Tak, usuń pracownika
                            </button>
                        </form>

                        <a href="usun_pracownika.php" class="return-btn">
                            <i class="fas fa-times"></i> Anuluj
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="employee-list">
                    <h2>Wybierz pracownika do usunięcia</h2>

                    <?php if (empty($pracownicy)): ?>
                        <p>Brak pracowników w systemie.</p>
                    <?php else: ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Imię i Nazwisko</th>
                                    <th>Email</th>
                                    <th>Stanowisko</th>
                                    <th>Akcja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pracownicy as $pracownik): ?>
                                    <tr>
                                        <td><?php echo $pracownik['pracownik_id']; ?></td>
                                        <td><?php echo htmlspecialchars($pracownik['imie'] . ' ' . $pracownik['nazwisko']); ?></td>
                                        <td><?php echo htmlspecialchars($pracownik['email']); ?></td>
                                        <td>
                                            <?php
                                            switch ($pracownik['stanowisko']) {
                                                case 'admin':
                                                    echo '<span style="color: #dc3545;"><i class="fas fa-user-shield"></i> Administrator</span>';
                                                    break;
                                                case 'kierownik':
                                                    echo '<span style="color: #fd7e14;"><i class="fas fa-user-tie"></i> Kierownik</span>';
                                                    break;
                                                default:
                                                    echo '<span style="color: #28a745;"><i class="fas fa-user"></i> Pracownik</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($pracownik['pracownik_id'] != $_SESSION['pracownik_id']): ?>
                                                <form method="POST" action="">
                                                    <input type="hidden" name="pracownik_id"
                                                        value="<?php echo $pracownik['pracownik_id']; ?>">
                                                    <button type="submit" name="potwierdz_usuniecie" class="cancel-btn">
                                                        <i class="fas fa-trash-alt"></i> Usuń
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="employee-status">
                                                    <i class="fas fa-lock"></i> Bieżący użytkownik
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>