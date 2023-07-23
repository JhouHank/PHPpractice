<?php
    $page = isset($_POST["page"]) ? $_POST["page"] : 1;
    //echo "{$page}<br/>";
    //檢查前端網頁中用POST傳來的page參數是否存在，如果存在，則將page的值賦值給$page變數，否則將$page設為預設值1。
    $rpp = 10; //一頁有幾筆資料
    $start = ($page -1) * $rpp;
    //$start變數是查詢資料的起始索引，當$page=1時，$start為0，
    //代表從索引值為0開始查詢資料，第二頁從索引值10開始查詢，為第11筆資料。

    $mysqli = new mysqli('localhost','root','root', 'cust', 3306);
    $mysqli->set_charset('utf8');

    // 換一招 : prepare不用store_result跟bind_result
    $sql = 'SELECT * FROM food ORDER BY id LIMIT ?, ?';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii', $start, $rpp); //因為有問號，所以還是得用bind //因為$start跟$rpp兩個都是整數，所以是ii
    $stmt->execute();
    $result = $stmt->get_result(); //用get_result()將查詢結果儲存成一個物件

    $root = []; //預計會將資料以陣列的形式儲存，先創一個空陣列出來
    while($row = $result->fetch_object()){
        //用fetch_object()從儲存結果的物件中獲取資料，並以物件的形式回傳
        //並將回傳的資料塞進$row變數裡
        //echo "{$row->id} : {$row->name} : {$row->pic}<br/>";  //先自我驗證，這行要單獨執行
        $root[] = $row; //把這些物件塞進剛剛創的陣列裡面
    }
    $json = json_encode($root); //將剛剛的陣列編碼成JSON格式
    echo $json; //這行不能註解，因為這就是要傳過去的資料
?>