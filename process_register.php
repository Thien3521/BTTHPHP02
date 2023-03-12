<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once('database/db.php');
require_once('Utils/MyEmailServer.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    $sql = "SELECT COUNT(*) AS count FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['count'] > 0) {
        echo "<h3 class='text-warning'>Email đã tồn tại</h3>";
        echo "<button onclick='window.history.back()'>Quay lại</button>";
        exit();
    }

    // Kiểm tra xem mật khẩu đã nhập đúng hay chưa
    if ($pass1 !== $pass2) {
        echo "<h3 class='text-warning'>Mật khẩu nhập lại chưa đúng</h3>";
        echo "<button onclick='window.history.back()'>Quay lại</button>";
        exit();
    }

    $code_hash = md5(uniqid(rand(), true));

    // Tạo một câu lệnh SQL để chèn dữ liệu vào bảng
    $sql = "INSERT INTO users (username, email, password, code_hash) VALUES (:username, :email, :password, :code_hash)";
    $stmt = $conn->prepare($sql);

    // Băm mật khẩu
    $pass1 = password_hash($pass1, PASSWORD_DEFAULT);

    // Bind các giá trị vào câu lệnh SQL
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $pass1, PDO::PARAM_STR);
    $stmt->bindParam(':code_hash', $code_hash, PDO::PARAM_STR);

   // Thực thi câu lệnh SQL
   if ($stmt->execute()) {
    // gửi email xác nhận
    $to = $email;
    $subject = 'Xác nhận đăng kí tài khoản';
    $message = "Xin chào $username,\n\nBạn vừa đăng kí tài khoản trên website của chúng tôi.\n\nVui lòng nhấp vào liên kết sau để xác nhận đăng kí:\n\n";
    $message .= "http://localhost/CSE485_BTTH03_2023/activate.php?email=" . urlencode($email) . "&code_hash=$code_hash";

    $emailServer = new MyEmailServer();
    $emailServer->setTo($to);
    $emailServer->setSubject($subject);
    $emailServer->setMessage($message);
    $emailServer->sendEmail($to, $subject, $message);


    if ($emailServer->getStatus() == true) {
        echo "Đăng kí thành công! Vui lòng check gmail";
    }
    }
}
?>