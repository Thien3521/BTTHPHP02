<?php
$HOST = 'localhost';
$USERNAME = 'root';
$DB_NAME = 'btth03_cse485';
$PASSWORD = '';
$conn = new PDO("mysql:host=" . $HOST . ";dbname=" . $DB_NAME . ";charset=utf8", $USERNAME, $PASSWORD);
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
if (!$conn) {
    echo "Connect failed";
}
?>