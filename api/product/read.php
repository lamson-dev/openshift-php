<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("x-powered-by: Lam Son Server");

// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new Product($db);

// query products in database
$stmt = $product->read();
$num = $stmt->rowCount();

// check if more than 0 found
if ($num > 0) {
    
    // products array
    $product_arr = array();
    $product_arr["records"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // $row['name] to => $id, $name, $blabla,...
        extract($row);

        $product_item = array(
            "id"=>$id,
            "name"=>$name,
            "description"=>html_entity_decode($description),
            "price"=>$price,
            "category_id"=>$category_id,
            "category_name"=>$category_name
        );

        array_push($product_arr["records"], $product_item);
    }

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($product_arr);
}else{
    // set response code - 404 Not found
    http_response_code(404);

    echo json_encode(
        array("message"=>"No products found.")
    );
}

?>