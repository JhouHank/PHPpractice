<?php
    session_start();
    if (!isset($_SESSION['id'])) header('Location: login.php');
    $account = $_SESSION["account"];
    $mysqli = new mysqli('localhost','root','root', 'cust', 3306);
    $mysqli->set_charset('utf8');

    // 換一招 : prepare不用store_result跟bind_result
    $sql = 'SELECT * FROM member WHERE account = ?';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $account);
    $stmt->execute();
    $result = $stmt->get_result(); //用get_result()將查詢結果儲存成一個物件

    $memberlist = []; //預計會將資料以陣列的形式儲存，先創一個空陣列出來
    while($row = $result->fetch_object()){
        //用fetch_object()從儲存結果的物件中獲取資料，並以物件的形式回傳
        //並將回傳的資料塞進$row變數裡
        //echo "{$row->id} : {$row->account} : {$row->realname} : {$row->photo}<br/>";  //先自我驗證，這裡要單獨執行
        $memberlist[] = $row; //把這些物件塞進剛剛創的陣列裡面
    }
    $json = json_encode($memberlist); //將剛剛的陣列編碼成JSON格式
    echo $json; //這行不能註解，因為這就是要傳過去的資料
?>