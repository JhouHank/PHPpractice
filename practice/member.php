<meta charset="utf-8" />
<?php
    session_start();
    if (!isset($_SESSION['id'])) header('Location: login.php');
    $realname = $_SESSION['realname'];
?>
<script>
    let xhttp = new XMLHttpRequest();
    function fetchMemberData() { //抓會員資料
        xhttp.onreadystatechange = callback;
        let url = "getMember.php"; 
        xhttp.open("post", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    }
    function callback(){
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            let memberlist = JSON.parse(xhttp.responseText); 
        
            for (let i = 0; i < memberlist.length; i++) { //這邊感覺寫的不夠好，因為只有自己的會員資料，所以不用迴圈？
                let row = memberlist[i];
                let table = document.getElementById("table"); //要把資料塞進table中，所以要抓table的DOM
                let tr = document.createElement("tr"); //創建<tr>

                let td_account = document.createElement("td"); //創建<td>並命名為td_account
                td_account.innerHTML = row.account; //在td_account裡面塞row.account
                tr.appendChild(td_account); //在tr的子層塞入td_account

                let td_password = document.createElement("td"); 
                td_password.innerHTML = `<input type="button" value="變更密碼" onclick="changePW()" />`;
                tr.appendChild(td_password); 

                let td_realname = document.createElement("td"); 
                td_realname.innerHTML = row.realname; 
                tr.appendChild(td_realname); 

                let td_photo = document.createElement("td"); 
                td_photo.innerHTML = `<img src="${row.photo}" width="200px"/>
                <br/><input type="button" value="上傳大頭貼" onclick="uploadPhoto()" />`; 
                tr.appendChild(td_photo); 

                table.appendChild(tr); //在table的子層塞入tr
            }
            
        }
    }
    function logout(){
        window.location.href = "http://localhost/PHP/logout.php";
    }
    function main(){
        window.location.href = "http://localhost/PHP/main.php";
    }
    function uploadPhoto(){
        window.location.href = "http://localhost/PHP/uploadPhoto.php";
    }
    function changePW(){
        window.location.href = "http://localhost/PHP/rePassword.php";
    }
    fetchMemberData(); //進去會員頁面就要抓會員資料
</script>
<h1>會員專區</h1>
<hr />
Welcome, <?php echo $realname; ?>
<hr />
<input type="button" value="登出" onclick="logout()">
<hr />
<input type="button" value="餐廳列表" onclick="main()" />
<hr />
<table id="table" border="1" width="100%">
    <tr>
        <th>會員帳號</th>
        <th>密碼</th>
        <th>真實姓名</th>
        <th>大頭貼</th>
    </tr>
</table>
