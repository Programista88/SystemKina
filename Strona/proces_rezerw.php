<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$film_id = $_GET['film_id'] ?? null;

if (!$film_id) {
    header('Location: index.php');
    exit();
}


$stmt = $db->prepare("SELECT * FROM filmy WHERE film_id = ?");
$stmt->execute([$film_id]);
$film = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $db->prepare("
    SELECT s.*, sa.nazwa_sali, sa.sala_id 
    FROM seanse s
    JOIN sale sa ON s.sala_id = sa.sala_id
    WHERE s.film_id = ? AND s.data_seansu > NOW()
    ORDER BY s.data_seansu
");
$stmt->execute([$film_id]);
$seanse = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seans_id = $_POST['seans_id'] ?? null;
    $miejsce_id = $_POST['miejsce_id'] ?? null;

    if ($seans_id && $miejsce_id) {
        try {

            $stmt = $db->prepare("
                SELECT 1 FROM rezerwacje 
                WHERE seans_id = ? AND miejsce_id = ? AND status = 'aktywna'
            ");
            $stmt->execute([$seans_id, $miejsce_id]);

            if (!$stmt->fetch()) {

                $stmt = $db->prepare("
                    INSERT INTO rezerwacje (klient_id, seans_id, miejsce_id, data_rezerwacji, status) 
                    VALUES (?, ?, ?, NOW(), 'aktywna')
                ");
                if ($stmt->execute([$_SESSION['user_id'], $seans_id, $miejsce_id])) {
                    $_SESSION['message'] = 'Rezerwacja została pomyślnie utworzona!';
                    $_SESSION['message_type'] = 'success';
                    header('Location: rezerwacje.php');
                    exit();
                }
            } else {
                $error = "To miejsce jest już zajęte";
            }
        } catch (PDOException $e) {
            $error = "Błąd podczas rezerwacji";
        }
    } else {
        $error = "Wybierz seans i miejsce";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Rezerwacja biletu - <?php echo htmlspecialchars($film['tytul']); ?></title>
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

    <main class="reservation-process">
        <h2>Rezerwacja biletu na film: <?php echo htmlspecialchars($film['tytul']); ?></h2>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" id="reservationForm">
            <div class="showtime-selection">
                <h3>Wybierz seans:</h3>
                <select name="seans_id" id="seans_id" required>
                    <option value="">Wybierz datę i godzinę</option>
                    <?php foreach ($seanse as $seans): ?>
                        <option value="<?php echo $seans['seans_id']; ?>">
                            <?php echo date('d.m.Y H:i', strtotime($seans['data_seansu'])); ?>
                            - <?php echo htmlspecialchars($seans['nazwa_sali']); ?>
                            - <?php echo number_format($seans['cena'], 2); ?> zł
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="seat-selection">
                <h3>Wybierz miejsce:</h3>
                <div id="seatMap" class="seat-map"></div>
                <input type="hidden" name="miejsce_id" id="miejsce_id" required>
            </div>

            <button type="submit" class="submit-btn">Zarezerwuj bilet</button>
        </form>
    </main>

    <script>
        document.getElementById('seans_id').addEventListener('change', function () {
            const seansId = this.value;
            if (seansId) {
                fetch(`get_available_seats.php?seans_id=${seansId}`)
                    .then(response => response.json())
                    .then(data => {
                        const seatMap = document.getElementById('seatMap');
                        seatMap.innerHTML = '';
                        let currentRow = 0;
                        let rowDiv;

                        data.forEach(seat => {
                            if (currentRow !== seat.numer_rzedu) {
                                currentRow = seat.numer_rzedu;
                                rowDiv = document.createElement('div');
                                rowDiv.className = 'seat-row';
                                seatMap.appendChild(rowDiv);
                            }

                            const seatDiv = document.createElement('div');
                            seatDiv.className = `seat ${seat.zajete === '1' ? 'occupied' : ''}`;
                            seatDiv.textContent = seat.numer_miejsca;
                            seatDiv.dataset.miejsceId = seat.miejsce_id;

                            if (seat.zajete !== '1') {
                                seatDiv.addEventListener('click', function () {
                                    document.querySelectorAll('.seat.selected').forEach(s => s.classList.remove('selected'));
                                    this.classList.add('selected');
                                    document.getElementById('miejsce_id').value = this.dataset.miejsceId;
                                });
                            }

                            rowDiv.appendChild(seatDiv);
                        });
                    });
            }
        });
    </script>
</body>

</html>