<?php

include_once "db.php";
error_reporting(E_ERROR | E_PARSE);

// Функция для генерации выпадающего меню с брендами
function brandMenu(){
    global $link;
    $sql = 'SELECT * FROM `supplier`';
    $brands = mysqli_query($link, $sql);
    // echo $brand["id"];
    //echo $sql;
    // echo $brand["namesupplier"];
    foreach ($brands as $brand) {
        
        //echo $_GET["brand"];
        // Если в GET-запросе был передан параметр "brand" и он совпадает с текущим поставщиком, то добавляем атрибут "selected" к option
        if (htmlspecialchars($_GET["brand"]) != '' && htmlspecialchars($_GET["brand"]) == $brand["id"]) {
            echo '<option value="'.$brand["id"].'" selected>'.$brand["namesupplier"].'</option>';
        }else {                                   
            echo '<option value="'.$brand["id"].'">'.$brand["namesupplier"].'</option>';
        }
    }
    
}