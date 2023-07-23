<?php
    session_start();
    if (!isset($_SESSION['id'])) header('Location: login.php');
    $account = $_SESSION['account'];
    $upload = $_FILES['upload'];
    $photo = $_SESSION['photo'];
    // var_dump($upload);
    if ($upload['error'] == 0){
        if (move_uploaded_file($upload['tmp_name'], 
            "upload/{$upload['name']}")){
            //上傳成功，也移動成功
            echo '上傳成功，5秒後跳轉到會員專區';
        }else{
            //上傳成功，但移動失敗
            echo '上傳成功，但移動失敗';
        }
    }else{
        ////上傳失敗
        echo '上傳失敗，失敗代碼：'. $upload['error'];
    }
    $photoUrl = 'http://localhost/PHP/upload/' . $upload['name'];
    $mysqli = new mysqli('localhost','root','root','cust',3306);
    $mysqli->set_charset('utf8');
    $sql = 'UPDATE member SET photo = ? WHERE account = ?';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss',$photoUrl,$account);
    $stmt->execute();
    // $oldphoto = str_replace("http://localhost/PHP/upload/", "upload/", $photo);
    // unlink($oldphoto); 
    // 如果使用者一直上傳新的大頭貼，資料可能會爆(?)
    // 想要刪舊的大頭貼，但不知道怎麼寫比較好。
?>
<script>
    function gotologin(){
        window.location.href = "http://localhost/PHP/member.php";
    }
    setInterval(gotologin, 5000);
</script>