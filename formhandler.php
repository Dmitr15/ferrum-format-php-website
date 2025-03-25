<?php
include_once "db.php";
error_reporting(E_ERROR | E_PARSE);


// Функция для отображения введенного значения в поле описание товара
function descriptionHandler(){
    //global $link;
    if ($_GET["description"]!="" && $_GET["clearFilter"]=="") {
        //echo mysqli_real_escape_string($link, $_GET['description']);        
        echo $_GET['description'];                          
    }
}


// Функция для формирования SQL-запроса с учетом фильтров
function sqlFilter(){
    
    global $link;
    // Базовый SQL-запрос для выборки всех данных
    $sql="SELECT supplier.namesupplier, product.img_path, product.name, product.description, product.cost FROM product right outer join supplier on supplier.id= product.id_supplier WHERE 1";

    // Проверяем, были ли переданы какие-либо параметры через GET-запрос
    if (count($_GET)>0 ) {
        $brand = mysqli_real_escape_string($link, $_GET['brand']);
        $description = mysqli_real_escape_string($link, $_GET['description']);
        $nameProduct = mysqli_real_escape_string($link, $_GET['nameProduct']);
        $startPrice = mysqli_real_escape_string($link, $_GET['startPrice']);
        $andPrice = mysqli_real_escape_string($link, $_GET['andPrice']);

        // Если передан параметр "brand", добавляем условие фильтрации по бренду
        if (!empty($brand)) {
            $sql = $sql." AND supplier.id = '$brand'";
        }

        // Если передан параметр "description", добавляем условие фильтрации по описанию
        if (!empty($description)) {
            $sql = $sql." AND product.description LIKE '%$description%'";
        }

        // Если передан параметр "nameProduct", добавляем условие фильтрации по названию продукта
        if (!empty($nameProduct)) {
            $sql = $sql." AND product.name LIKE '%$nameProduct%'";
        }

        // Если передан только параметр "startPrice", добавляем условие фильтрации по минимальной цене
        if (strlen($startPrice) !=0  && strlen($andPrice) ==0 ) {
            $sql = $sql." AND product.cost >= CAST($startPrice AS SIGNED) ORDER BY product.cost DESC";
        }

        // Если передан только параметр "andPrice", добавляем условие фильтрации по максимальной цене
        if (strlen($startPrice) ==0  && strlen($andPrice) !=0) {
            $sql = $sql." AND product.cost <= CAST($andPrice AS SIGNED) ORDER BY product.cost ASC";
        }

        // Если переданы оба параметра "startPrice" и "andPrice", добавляем условие фильтрации по диапазону цен
        if (strlen($startPrice) != 0  && strlen($andPrice) !=0) {
            $sql = $sql." AND product.cost BETWEEN CAST($startPrice AS SIGNED) AND CAST($andPrice AS SIGNED) ORDER BY product.cost ASC";
        
         }
        
    }
    
    $result = mysqli_query($link, $sql);
return $result;
}
