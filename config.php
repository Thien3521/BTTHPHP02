<?php
use Twig\Loader\FilesystemLoader;
$db_host = 'localhost';
$db_name = 'btth01_cse485';
$db_user = 'root';
$db_pass = '';

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$loader = new FilesystemLoader(__DIR__ . '/views');
