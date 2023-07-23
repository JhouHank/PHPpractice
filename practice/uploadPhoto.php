<?php
session_start();
if (!isset($_SESSION['id'])) header('Location: login.php');
$account = $_SESSION['account'];
?>
<form action="photo.php" method="post" enctype="multipart/form-data">
<!-- 一般情況下，表單數據（如文本字段）是使用默認的編碼方式application/x-www-form-urlencoded進行編碼，
但這種方式無法處理文件上傳，因為文件數據是二進制數據，而不是普通的文本數據。 -->
<!-- 使用enctype="multipart/form-data"時，表單數據將以多部分（multipart）的形式進行編碼，
這樣可以在同一次表單提交中包含文本字段和文件數據。這樣的編碼方式允許瀏覽器將文件數據和表單數據進行分離
，並在服務器端進行解析處理。 -->
    <table  border="1" width="20%" style="margin:0 auto;">
        <tr>
            <th>
                <input type="file" name="upload" id="uploadInput" onchange="previewImage(event)" />
            </th>
        </tr>
        <tr>
            <td>
            <img id="preview" src="#" alt="預覽圖片" style="display: none; max-width: 100%;" />
            </td>
        </tr>
        <tr>
            <td>
                <div  style="display:flex;justify-content:center;">
                    <input type="submit" value="上傳"/><br/>
                    <input type="button" value="取消" onclick="cancel()"/>
                </div>
            </td>
        </tr>
    </table>
</form>
<script>
function previewImage(event) { //預覽圖片
    let input = event.target; //event是一個「事件」物件，而event.target是該物件的元素
    if (input.files && input.files[0]) {
        //files(event.target.files)是JS內建的FileList物件，包含所有使用者在「選擇檔案」的input中輸入的所有檔案
        //而input.files[0]是第1個元素
        //寫成這樣是為了避免使用者未選擇檔案的情況，且是取得了第一個檔案
        let reader = new FileReader(); //FileReader是一個物件，用來讀取本地的檔案內容
        reader.onload = function(e) { //當FileReader讀取完檔案時，就會觸發這個內建的onload函式
            let preview = document.getElementById('preview'); //抓取ID為preview的img標籤DOM
            preview.src = e.target.result; //將讀取完的結果，賦值給img標籤的src屬性
            preview.style.display = 'block'; //讓img顯示
        };
        reader.readAsDataURL(input.files[0]); 
        //readAsDataURL()是FileReader物件的方法，將檔案以DataURL的格式進行讀取
        //DataURL是一種特殊的URL格式，它可以將檔案的內容直接嵌入到URL中，以便在網頁中直接顯示或使用。
    }
}
function cancel(){
    window.location.href = "http://localhost/PHP/member.php";
}
</script>