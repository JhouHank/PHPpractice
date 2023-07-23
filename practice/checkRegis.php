<meta charset="utf-8" />
<?php
    if (isset($_GET['account'])){
        $account = $_GET['account'];
        $mysqli = new mysqli('localhost','root','root', 'cust', 3306);
        $mysqli->set_charset('utf8');
        $sql = 'SELECT account FROM member WHERE account = ?';
        //搜尋資料表中有沒有相同的帳號
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $account);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows() > 0){
            //大於0表示有相同帳號
            echo '帳號已存在';
        }else{
            //小於0表示沒有相同帳號
            echo '可以使用此帳號';
        }
    }
?>