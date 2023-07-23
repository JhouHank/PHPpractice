<?php
    session_start();
    //if (!isset($_SESSION['id'])) header('Location: login.php');
    $account = $_SESSION['account'];
    // $oldPassword = $_POST['oldPassword'];
    $newPassword = password_hash($_POST['newPassword'],PASSWORD_DEFAULT); ;
    $mysqli = new mysqli('localhost','root','root', 'cust', 3306);
    $mysqli->set_charset('utf8');
    $sql = 'UPDATE member SET password = ? WHERE account = ?';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $newPassword,$account);
    if($stmt->execute()){
        echo '更改成功，5秒後登出並跳轉到登入頁面';
    }else{
        echo '更改失敗，5秒後登出並跳轉到登入頁面';
    }
?>
<script>
    function gotologout(){
        window.location.href = "http://localhost/PHP/logout.php";
    }
    setInterval(gotologout, 5000);
</script>