<?php
    session_start();
    if (!isset($_SESSION['id'])) header('Location: login.php');
?>
<form action="changePW.php" method="post">
    <label for="oldPassword"> 請輸入舊密碼: </label>
    <input type="password" name="oldPassword" id="oldPassword" oninput="checkOldPW()"/>
    <span id="msg"></span><br />
    <label for="newPassword"> 請輸入新密碼: </label>
    <input type="password" name="newPassword" id="newPassword" oninput="checkSame()" />
    <span id="msgSame"></span><br />
    <input type="submit" value="確認更改"/>
    <input type="button" value="取消" onclick="cancel()"/>
</form>
<script>
    let xhttp = new XMLHttpRequest();
    function checkOldPW() { //先驗證舊密碼
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
        document.getElementById("msg").innerHTML = xhttp.responseText;
        }
    };
    let oldPassword = document.getElementById("oldPassword").value;
    xhttp.open("GET", `checkOldPW.php?oldPassword=${oldPassword}`, true);
    xhttp.send();
    }
    
    let xhttp2 = new XMLHttpRequest(); //這邊的變數要跟上面的不一樣 //因為是向兩個不同的檔案傳遞資料(?)
    function checkSame() {
    xhttp2.onreadystatechange = function () {
        if (xhttp2.readyState == 4 && xhttp2.status == 200) {
        document.getElementById("msgSame").innerHTML = xhttp2.responseText;
        }
    };
    let newPassword = document.getElementById("newPassword").value;
    xhttp2.open("GET", `checkSame.php?newPassword=${newPassword}`, true);
    xhttp2.send();
    }
    
    function cancel(){
        window.location.href = "http://localhost/PHP/member.php";
    }
</script>