<?php
require_once 'vendor/autoload.php';
require_once 'config.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// $loader = new FilesystemLoader('views');
// $twig = new Environment($loader);

// $action = isset($_GET['action']) ? $_GET['action'] : '';

// switch ($action) {
//     case 'add':
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $name = $_POST['name'];
//             $email = $_POST['email'];
//             $stmt = $db->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
//             $stmt->execute([$name, $email]);
//             header('Location: index.php');
//             exit;
//         }
//         echo $twig->render('add.twig');
//         break;
//     case 'edit':
//         $id = $_GET['id'];
//         $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
//         $stmt->execute([$id]);
//         $user = $stmt->fetch(PDO::FETCH_ASSOC);
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $name = $_POST['name'];
//             $email = $_POST['email'];
//             $stmt = $db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
//             $stmt->execute([$name, $email, $id]);
//             header('Location: index.php');
//             exit;
//         }
//         echo $twig->render('edit.twig', ['user' => $user]);
//         break;
//     case 'delete':
//         $id = $_GET['id'];
//         $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
//         $stmt->execute([$id]);
//         header('Location: index.php');
//         exit;
//         break;
//     default:
//         $stmt = $db->query("SELECT * FROM users");
//         $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//         echo $twig->render('index.twig', ['users' => $users]);
//         break;
// }

$loader = new FilesystemLoader('views');
$twig = new Environment($loader);

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve data from $_POST superglobal
            $tieude = $_POST['tieude'];
            $ten_bhat = $_POST['ten_bhat'];
            $ma_tloai = $_POST['ma_tloai'];
            $tomtat = $_POST['tomtat'];
            $noidung = $_POST['noidung'];
            $ma_tgia = $_POST['ma_tgia'];
            $ngayviet = $_POST['ngayviet'];
            $hinhanh = $_POST['hinhanh'];

            // Insert data into database using a prepared statement
            $stmt = $db->prepare("INSERT INTO baiviet (tieude, ten_bhat, ma_tloai, tomtat, noidung, ma_tgia, ngayviet, hinhanh) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh]);

            // Redirect to index page
            header('Location: index.php');
            exit;
        }
        echo $twig->render('add.twig');
        break;
    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve data from $_POST superglobal
            $id = $_POST['id'];
            $tieude = $_POST['tieude'];
            $ten_bhat = $_POST['ten_bhat'];
            $ma_tloai = $_POST['ma_tloai'];
            $tomtat = $_POST['tomtat'];
            $noidung = $_POST['noidung'];
            $ma_tgia = $_POST['ma_tgia'];
            $ngayviet = $_POST['ngayviet'];
            $hinhanh = $_POST['hinhanh'];

            // Update data in database using a prepared statement
            $stmt = $db->prepare("UPDATE baiviet SET tieude = ?, ten_bhat = ?, ma_tloai = ?, tomtat = ?, noidung = ?, ma_tgia = ?, ngayviet = ?, hinhanh = ? WHERE ma_bviet = ?");
            $stmt->execute([$tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh, $id]);

            // Redirect to index page
            header('Location: index.php');
            exit;
        } else {
            // Retrieve data from $_GET superglobal
            $id = $_GET['id'];

            // Query the database for the selected record
            $stmt = $db->prepare("SELECT * FROM baiviet WHERE ma_bviet = ?");
            $stmt->execute([$id]);
            $baiviet = $stmt->fetch(PDO::FETCH_ASSOC);

            // Render the edit page with the retrieved data
            echo $twig->render('edit.twig', ['baiviet' => $baiviet]);
            break;
        }

        case 'delete':
            // Retrieve data from $_GET superglobal
            $id = $_GET['id'];
                // Delete the selected record from the database
            $stmt = $db->prepare("DELETE FROM baiviet WHERE ma_bviet = ?");
            $stmt->execute([$id]);

            // Redirect to index page
            header('Location: index.php');
            exit;
            break;
        default:
            // Query the database for all records
            $stmt = $db->query("SELECT * FROM baiviet ORDER BY ngayviet DESC");
            $baiviets = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Render the index page with the retrieved data
            echo $twig->render('index.twig', ['baiviets' => $baiviets]);
            break;
        }


