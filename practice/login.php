<meta charset="utf-8" />
<?php
    include 'hankAPI.php';
    session_start();
    if (isset($_POST['account']) && isset($_POST['password'])){
        $account = $_POST['account']; 
        $password = $_POST['password'];
        //用POST語法，取得login.html中，name為account的值，並且放入$account這個變數當中
        $mysqli = new mysqli('localhost','root','root', 'cust', 3306);
        $mysqli->set_charset('utf8');
        //mysqli使PHP能夠與資料庫連線
        //其參數第一個為hostname(IP)，第二個是username，第三個是password
        //第四個是資料庫，第五個為port號
        $sql = 'SELECT id,account,password,realname,photo FROM member WHERE account = ?';
        //用一個名為sql的變數，把mysql的語法塞進去，並且用問號(?)來代替我們要輸入的資料
        $stmt = $mysqli->prepare($sql);
        //準備把mysql語法塞進資料庫，但還沒執行
        $stmt->bind_param('s', $account);
        //bind_param('參數型態',參數1,參數2,參數...)，參數會依序塞進sql語法的問號中
        //用bind_param語法，把$account這個變數的值，塞進上面sql變數中，mysql語法的問號(?)裡面，
        //且這個值是字串(s)
        //參數有幾個，就要寫幾個參數型態
        $stmt->execute(); //執行sql語法
        $stmt->store_result(); //將執行後的結果儲存
        if ($stmt->num_rows() > 0){
        //num_row是查詢結果中的資料列數量（即記錄數量）
        //而寫成大於0是為了檢查有沒有回傳資料(就是確認查詢結果有沒有東西)
            $stmt->bind_result($id,$account,$hashpassword,$realname,$photo);
            //用bind_result將查詢結果的資料，依序綁定到stmt的參數中
            //這邊會使用$hashpassword是因為這個資料是從後端抓的，不是使用者在login的地方輸入的
            //可以讓後端抓的資料跟前端使用者輸入的資料在下面做比對
            $stmt->fetch();
            //從$stmt中獲取資料
            if (password_verify($password, $hashpassword)){
                // 使用者輸入的密碼，與後端所儲存的加密後密碼，兩個之間驗證成功
                $_SESSION['id'] = $id;
                $_SESSION['account'] = $account;
                $_SESSION['realname'] = $realname;
                $_SESSION['photo'] = $photo;
                $_SESSION['member'] = new Member($id, $account, $realname, $photo);
                header('Location: main.php');
                //header為轉向的函式
            }else{
                // 驗證失敗
                header('Location: login.html');
            }
        }else{
            // 沒有資料(沒有這個帳號)
            header('Location: login.html');
        }
    }else{
        // 表格中輸入的帳號密碼沒有傳過來
        header('Location: login.html');
    }
?>