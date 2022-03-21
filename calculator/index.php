<!DOCTYPE html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">

<?php include('calculator.php'); ?>

<div class="result"><?=$result;?></div>
<div class="calc_grid">
    <?php
    $values = [7,8,9,"+", 4,5,6,"-", 1,2,3, "="];

    foreach ($values as $value) { ?>
    <a href="?<?=http_build_query(["btn" => $value, "result" => $result]);?>"><?=$value;?></a>

    <?php
    }


    ?>
</div>

<a href="?reset=true">reset</a>