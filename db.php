<?php

error_reporting(E_ERROR | E_PARSE);

// Проверяем, был ли передан параметр clearFilter через GET-запрос
if ($_GET["clearFilter"] !='') {
    header("Location: http://localhost/mySite/index.php");
}

// Устанавливаем соединение с базой данных MySQL
$link = mysqli_connect("localhost", "root", "", "lr2");  