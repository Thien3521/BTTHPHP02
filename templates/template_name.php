<?php
require_once 'vendor/autoload.php';

// Tạo một đối tượng Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__);
$twig = new \Twig\Environment($loader);

// Kết xuất
echo $twig->render('template_name.twig', array('variable_name' => 'variable_value'));
