<?php
error_reporting(E_ERROR | E_PARSE);

// Проверяем, был ли передан параметр clearFilter через GET-запрос
if ($_GET["clearFilter"] !='') {
    header("Location: http://localhost/mySite/index.php");
}

// Устанавливаем соединение с базой данных MySQL
$link = mysqli_connect("localhost", "root", "", "lr2");  

// Функция для проверки, заканчивается ли SQL-запрос на "WHERE"
/**
 * @param string $sql
 * @return string $sql
 */
function end_with(string $sql){
    if (!str_ends_with($sql, 'WHERE')) {
        $sql .= ' AND';
    }
    return $sql;
}

// Функция для генерации выпадающего меню с брендами
function brandMenu(){
    global $link;
    $sql = 'SELECT namesupplier FROM supplier';
    $result = mysqli_query($link, $sql);
    foreach ($result as $fruit) {
        // Если в GET-запросе был передан параметр "brand" и он совпадает с текущим поставщиком, то добавляем атрибут "selected" к option
        if (htmlspecialchars($_GET["brand"]) != '' && htmlspecialchars($_GET["brand"]) == $fruit["namesupplier"]) {
            echo '<option value="'.$fruit["namesupplier"].'" selected>'.$fruit["namesupplier"].'</option>';
        }else {                                   
            echo '<option value="'.$fruit["namesupplier"].'">'.$fruit["namesupplier"].'</option>';
        }
    }
}

function descriptionHandler(){
    if (htmlspecialchars($_GET["description"])!="" && $_GET["clearFilter"]=="") {                                         
        echo'<textarea type="text" name="description" id="descriptionName" class="form-control" placeholder="Введите описание товара" required>'.htmlspecialchars($_GET["description"]).'</textarea>';
    }
    else{
        echo'<textarea type="text" name="description" id="descriptionName" class="form-control" placeholder="Введите описание товара" required></textarea>';
    }
}


// Функция для формирования SQL-запроса с учетом фильтров
function sqlFilter(){
    
    global $link;
    // Базовый SQL-запрос для выборки всех данных
    $sql="SELECT supplier.namesupplier, product.img_path, product.name, product.description, product.cost FROM product right outer join supplier on supplier.id= product.id_supplier";

    // Проверяем, были ли переданы какие-либо параметры через GET-запрос
    if (count($_GET)>0) {
        
        $sql .=' WHERE';

        // Если передан параметр "brand", добавляем условие фильтрации по бренду
        if (!empty(htmlspecialchars($_GET["brand"]))) {
            $sql = end_with($sql)." supplier.namesupplier = '".htmlspecialchars($_GET["brand"])."'";
        }

        // Если передан параметр "description", добавляем условие фильтрации по описанию
        if (!empty(htmlspecialchars($_GET["description"]))) {
            $sql = end_with($sql)." product.description LIKE '%".htmlspecialchars($_GET["description"])."%'";
        }

        // Если передан параметр "nameProduct", добавляем условие фильтрации по названию продукта
        if (!empty(htmlspecialchars($_GET["nameProduct"]))) {
            $sql = end_with($sql)." product.name LIKE '%".htmlspecialchars($_GET["nameProduct"])."%'";
        }

        // Если передан только параметр "startPrice", добавляем условие фильтрации по минимальной цене
        if (strlen(htmlspecialchars($_GET["startPrice"])) !=0  && strlen(htmlspecialchars($_GET["andPrice"])) ==0 ) {
            $sql = end_with($sql)." product.cost >= CAST(".htmlspecialchars($_GET["startPrice"]) ." AS SIGNED) ORDER BY product.cost DESC";
        }

        // Если передан только параметр "andPrice", добавляем условие фильтрации по максимальной цене
        if (strlen(htmlspecialchars($_GET["startPrice"])) ==0  && strlen(htmlspecialchars($_GET["andPrice"])) !=0) {
            $sql = end_with($sql)." product.cost <= CAST(".htmlspecialchars($_GET["andPrice"])." AS SIGNED) ORDER BY product.cost ASC";
        }

        // Если переданы оба параметра "startPrice" и "andPrice", добавляем условие фильтрации по диапазону цен
        if (strlen(htmlspecialchars($_GET["startPrice"])) != 0  && strlen(htmlspecialchars($_GET["andPrice"])) !=0) {
            $sql = end_with($sql)." product.cost BETWEEN CAST(".htmlspecialchars($_GET["startPrice"])." AS SIGNED) AND CAST(".htmlspecialchars($_GET["andPrice"])." AS SIGNED) ORDER BY product.cost ASC";
        }
        
    }
    
    $result = mysqli_query($link, $sql);
return $result;
}
