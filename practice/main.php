<meta charset="utf-8" />
<?php
    session_start();
    if (!isset($_SESSION['id'])) header('Location: login.php');
    $realname = $_SESSION['realname']
?>
<script>
    let page = 1; //初始設定為第一頁
    let xhttp = new XMLHttpRequest();
    //XMLHttpRequest是JavaScript內建的物件，用於進行 HTTP 或 HTTPS 通訊。

    function fetchPageData() {
        // 抓取頁面資料 //AJAX //回呼
        xhttp.onreadystatechange = callback;
        //只有定義，所以callback沒有加小括號
        //如果是callback()，這樣才叫做定義+執行

        //let url = "main.php"; //這裡用GET
        let url = "getFromfood.php"; //這裡用POST

        // let url = `main.php?page=${page}`;
        // xhttp.open("get", url, true);
        // xhttp.send();
        //上面三行是GET的做法
        xhttp.open("post", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`page=${page}`);
        //xhttp.send(`page=3`);
        //上面三行是POST的做法
    }

    function callback() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            //readyState為請求的狀態，狀態分為0到4，4代表已經接收到全部的回應資料，且請求已經完成。
            //status為http的狀態碼，200代表請求已成功處理，並且伺服器回傳了所需的資料，404為Not Found。
            let table = document.getElementById("table");
            //要把資料塞進table中，所以要抓table的DOM

            //目標：清除第二列以後的tr(把前一頁的東西清掉，塞下一頁的資料進去)
            //如果在for迴圈裡面抓length，然後砍trs[i]，砍第一個之後，第二個會往上跑，所以會砍1,3,5,7
            //畫面依然剩下2,4,6,8,10
            //有兩個方法解決
            //1.(在for迴圈之前)先抓length，然後永遠砍第一個，下面是使用第一種方法
            //2.從最後一個開始砍
            let trs = table.getElementsByTagName("tr");
            let len = trs.length;
            for (let i = 1; i < len; i++) {
                //console.log(`${i}:${trs.length}`);
                table.removeChild(trs[1]);
            }

            let root = JSON.parse(xhttp.responseText); //變數名稱沒有一定要一樣(getFromfood.php中的陣列變數名稱為root)，只是這樣寫剛好
            //console.log(root.length); //解析出來的資料為陣列 所以可以看他的length
            //這邊用JSON.parse()是因為getFromfood.php傳來的資料為JSON格式，所以用這個函式把JSON轉成JavaScript的物件或陣列

            //下面開始要塞資料進畫面
            for (let i = 0; i < root.length; i++) {
            let row = root[i];
            //console.log(`${row.id}:${row.name}`); //查看後端丟過來的資料是否正確
            let tr = document.createElement("tr"); //創建<tr>
            //下面要注意(row.參數)這邊的參數要跟JSON的物件名稱一模一樣
            let td_id = document.createElement("td"); //創建<td>並命名為td_id
            td_id.innerHTML = row.id; //在td_id裡面塞row.id
            tr.appendChild(td_id); //在tr的子層塞入td_id

            let td_name = document.createElement("td"); 
            td_name.innerHTML = row.name; 
            tr.appendChild(td_name); 

            let td_tel = document.createElement("td"); 
            td_tel.innerHTML = row.tel; 
            tr.appendChild(td_tel); 

            let td_pic = document.createElement("td"); 
            td_pic.innerHTML = `<img src="${row.pic}" width="200px"/>`;
            tr.appendChild(td_pic);

            table.appendChild(tr); //在table的子層塞入tr
            }
        }
    }
    function logout(){
        window.location.href = "http://localhost/PHP/logout.php";
    }
    function member(){
        window.location.href = "http://localhost/PHP/member.php";
    }
    function prev() {
        if (page > 1) { //不讓頁數少於1 //這邊寫得不夠好，是在湊數字
            page--;
            fetchPageData();
        }
    }
    function next() {
        if (page < 14) { //不讓頁數大於13
            page++;
            fetchPageData();
        }
    }
fetchPageData(); //一開始進來網頁的時候也要看到資料
</script>

<h1>Brad Big Company</h1>
<hr />
Welcome, <?php echo $realname; ?>
<hr />
<input type="button" value="登出" onclick="logout()">
<input type="button" value="會員專區" onclick="member()">
<hr />
<input type="button" value="上一頁" onclick="prev()" />
<input type="button" value="下一頁" onclick="next()" />
<!-- 這邊要注意是使用btn來觸發函式，並不是使用表單傳送的方式，所以是使用AJAX -->
<hr />
<table id="table" border="1" width="100%">
    <tr>
        <th>ID</th>
        <th>餐廳名稱</th>
        <th>電話號碼</th>
        <th>圖片</th>
    </tr>
</table>
