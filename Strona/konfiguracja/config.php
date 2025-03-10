<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'system_kina');
$host = 'localhost';
$dbname = 'system_kina';
$username = 'root';
$password = '';
try {
    $db = new PDO('mysql:host=localhost;dbname=system_kina', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Brak polaczenia: " . $e->getMessage();
}
