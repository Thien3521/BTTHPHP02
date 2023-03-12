<?php
require_once 'database/db.php';

$email = $_GET['email'];
$code_hash = $_GET['code_hash'];

// Kiểm tra xem email và mã hash có tồ
