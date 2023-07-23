<meta charset="utf-8" />
<?php
    session_start();
    if (!isset($_SESSION['id'])) header('Location: login.php');
    $account = $_SESSION['account'];
    if (isset($_GET['newPassword'])){
        // $oldPassword = $_GET['oldPassword'];
        $newPassword = $_GET['newPassword'];
        $mysqli = new mysqli('localhost','root','root', 'cust', 3306);
        $mysqli->set_charset('utf8');
        $sql = 'SELECT password FROM member WHERE account = ?';
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $account);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hashpassword);
        $stmt->fetch();
        if (password_verify($newPassword, $hashpassword)){
            echo '密碼重複，請輸入其他密碼';
        }else{
            echo '可以使用這個密碼';
        }
    }
?>