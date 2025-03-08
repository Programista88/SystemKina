<?php
$host = 'localhost';
$dbname = 'system_kina';
$username = 'root';
$password = '';

try {
    $db = new PDO('mysql:host=localhost;dbname=system_kina', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
