<?php
error_reporting(E_ERROR | E_PARSE);


if ($_GET["clearFilter"] !='') {
    
    header("Location: http://localhost/mySite/index.php");
}

$link = mysqli_connect("localhost", "root", "", "lr2");  

function end_with($sql){
    if (!str_ends_with($sql, 'WHERE')) {
        $sql .= ' AND';
    }
    return $sql;
}

function brandMenu(){
    global $link;
    $sql = 'SELECT namesupplier FROM supplier';
    $result = mysqli_query($link, $sql);
    foreach ($result as $fruit) {
        if (htmlspecialchars($_GET["brand"]) != '' && htmlspecialchars($_GET["brand"]) == $fruit["namesupplier"]) {
            echo '<option value="'.$fruit["namesupplier"].'" selected>'.$fruit["namesupplier"].'</option>';
        }else {                                   
            echo '<option value="'.$fruit["namesupplier"].'">'.$fruit["namesupplier"].'</option>';
        }
    }
}


function sqlFilter(){
    
    global $link;
    $sql="SELECT supplier.namesupplier, product.img_path, product.name, product.description, product.cost FROM product right outer join supplier on supplier.id= product.id_supplier";

    if (count($_GET)>0) {
        
        $sql .=' WHERE';
        if (!empty(htmlspecialchars($_GET["brand"]))) {
            $sql = end_with($sql)." supplier.namesupplier = '".htmlspecialchars($_GET["brand"])."'";
        }
        if (!empty(htmlspecialchars($_GET["description"]))) {
            $sql = end_with($sql)." product.description LIKE '%".htmlspecialchars($_GET["description"])."%'";
        }
        if (!empty(htmlspecialchars($_GET["nameProduct"]))) {
            $sql = end_with($sql)." product.name LIKE '%".htmlspecialchars($_GET["nameProduct"])."%'";
        }
        if (strlen(htmlspecialchars($_GET["startPrice"])) !=0  && strlen(htmlspecialchars($_GET["andPrice"])) ==0 ) {
            $sql = end_with($sql)." product.cost >= CAST(".htmlspecialchars($_GET["startPrice"]) ."AS SIGNED) ORDER BY product.cost DESC";
        }
        if (strlen(htmlspecialchars($_GET["startPrice"])) ==0  && strlen(htmlspecialchars($_GET["andPrice"])) !=0) {
            $sql = end_with($sql)." product.cost <= CAST(".htmlspecialchars($_GET["andPrice"])."AS SIGNED) ORDER BY product.cost ASC";
        }
        if (strlen(htmlspecialchars($_GET["startPrice"])) != 0  && strlen(htmlspecialchars($_GET["andPrice"])) !=0) {
            $sql = end_with($sql)." product.cost BETWEEN CAST(".htmlspecialchars($_GET["startPrice"])."AS SIGNED) AND CAST(".htmlspecialchars($_GET["andPrice"])."AS SIGNED) ORDER BY product.cost ASC";
        }
        
    }
    
    $result = mysqli_query($link, $sql);
return $result;
}
