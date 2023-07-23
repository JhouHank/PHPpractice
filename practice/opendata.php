<?php
// https://data.coa.gov.tw/Service/OpenData/ODwsv/ODwsvTravelFood.aspx
$json = file_get_contents('https://data.coa.gov.tw/Service/OpenData/ODwsv/ODwsvTravelFood.aspx');
//echo $json;

$data = json_decode($json, false);
//var_dump($data);

$mysqli = new mysqli('localhost','root','root','cust',3306);
$mysqli->set_charset('utf8');

$mysqli->query('DELETE FROM food');  //全部清空資料
$mysqli->query('ALTER TABLE food AUTO_INCREMENT = 1'); //ID從1開始

$sql = 'INSERT INTO food (name, tel, addr, hostwords, city, town, pic, lat, lng) VALUES (?,?,?,?,?,?,?,?,?)';
//name其實是保留字，如果要保險一點，在name的前後都加一個反引號(`)
$stmt = $mysqli->prepare($sql);
foreach($data as $k => $row){//因為外面那圈是陣列，所以才用foreach
    //echo "{$k} : {$row->City} : {$row->Name}<br/>"; //檢查資料有沒有正確，這行要獨立執行
    //每綁定一次，就執行一次
    $stmt->bind_param('sssssssdd', $row->Name, $row->Tel, $row->Address, $row->HostWords, $row->City, $row->Town, $row->PicURL, $row->Latitude, $row->Longitude); 
    //最後兩個是經緯度，當時在mysql的欄位設定是DOUBLE，所以要用d
    $stmt->execute();
} 
?>