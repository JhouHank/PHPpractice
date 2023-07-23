<meta charset="utf-8" />
<?php
    $account = $_POST['account'];  //有三種 $_GET 、 $_POST 、 $_REQUEST
    //要用哪一種，要對應到表單的method是哪一種，$_REQUEST則是不管前面用get還是post都可以
    $password =  password_hash( $_POST['password'],PASSWORD_DEFAULT); 
    //password_hash(要加密的東西, 要使用哪一種的編碼來加密)
    $realname = $_POST['realname'];
    $photo = 'http://localhost/PHP/img/default.png'; //預設大頭貼
    $mysqli = new mysqli('localhost','root','root','cust',3306);
    $mysqli->set_charset('utf8');
    $mysqli->query('ALTER TABLE member AUTO_INCREMENT = 1'); //ID從1開始
    $sql = 'INSERT INTO member (account, password, realname, photo) VALUES (?,?,?,?)';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssss',$account, $password, $realname, $photo); //四個值都是字串，所以四個s
    if($stmt->execute()){
        //有執行就註冊成功
        echo '註冊成功，5秒後跳轉到登入頁面';
    }else{
        //沒執行就註冊失敗
        echo '註冊失敗，5秒後跳轉到登入頁面';
    }
?>
<script>
    function gotologin(){
        window.location.href = "http://localhost/PHP/login.html";
    }
    setInterval(gotologin, 5000); //setInterval(要呼叫的函式, 每過幾千毫秒後呼叫)
</script>
