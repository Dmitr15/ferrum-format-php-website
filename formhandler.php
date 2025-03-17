<?php
error_reporting(E_ERROR | E_PARSE);
if($_SERVER["REQUEST_METHOD"]=="GET"){
    $startprice =  htmlspecialchars($_GET["startPrice"]);
    $endprice =  htmlspecialchars($_GET["andPrice"]);
    $brand = htmlspecialchars($_GET["brand"]);
    $description = htmlspecialchars($_GET["description"]);
    $nameProduct = htmlspecialchars($_GET["nameProduct"]);
    $clearFilter = htmlspecialchars($_GET["clearFilter"]);
}

if ($clearFilter !='') {
    $startprice = '';
    $endprice = '';
    $brand = '';
    $description = '';
    $nameProduct = '';
    header("Location: http://localhost/mySite/index.php");
}

$link = mysqli_connect("localhost", "root", "", "lr2");  

function sqlFilter(){
    global $link, $startprice, $endprice, $brand, $description, $nameProduct;
    $sql="SELECT supplier.namesupplier, product.img_path, product.name, product.description, product.cost FROM supplier, product WHERE supplier.id= product.id_supplier";
    $sql1 = "";

    if (strlen($startprice) !=0  && strlen($endprice) ==0 ) {
        $sql1 = $sql." AND product.cost >= CAST($startprice AS SIGNED) ORDER BY product.cost DESC";
    }
    if (strlen($startprice) ==0  && strlen($endprice) !=0) {
        $sql1 = $sql." AND product.cost <= CAST($endprice AS SIGNED) ORDER BY product.cost ASC";
    }
    if (strlen($startprice) != 0  && strlen($endprice) !=0) {
        $sql1 = $sql." AND product.cost BETWEEN CAST($startprice AS SIGNED) AND CAST($endprice AS SIGNED) ORDER BY product.cost ASC";
    }
    if (!empty($brand)) {
        $sql1 = $sql." AND supplier.namesupplier = '$brand'";
    }
    if (!empty($description)) {
        $sql1 = $sql." AND product.description LIKE '%$description%'";
    }
    if (!empty($nameProduct)) {
        $sql1 = $sql." AND product.name LIKE '%$nameProduct%'";
    }
    if(strlen($sql1) ==0){
        $result = mysqli_query($link, $sql);
    }
    else{
        $result = mysqli_query($link, $sql1);
    }

return $result;
}
