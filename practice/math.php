<?php
    $x = $y = $v = $result = $c = '';
    if(isset($_GET['x']) && isset($_GET['y'])){
        $x = $_GET['x'];
        $y = $_GET['y'];
        $option = $_GET['op'];
    }
    if($option == 1){
        $result = $x + $y;
    }else if($option == 2){
        $result = $x - $y;
    }else if($option == 3){
        $result = $x * $y;
    }else if($option == 4){
        $result = $x % $y;
        $v = (int)($x / $y);
        $c = "餘";
    }
?>
<form>
    <input name="x" value="<?= $x ?>">
    <select name="op">
        <option name='op' value='1'>+</option>
        <option name='op' value='2'>-</option>
        <option name='op' value='3'>*</option>
        <option name='op' value='4'>/</option>
    </select>
    <input name="y" value="<?= $y ?>">
    <input type="submit" value="=">
    <span><?= $v ?><?= $c ?><?= $result ?></span>
</form>
