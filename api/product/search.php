<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/product.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new Product($db);

// get keywords
$keywords = isset($_GET["s"]) ? $_GET["s"] : "";

// query products
$stmt = $product->search($keywords);
$num = $stmt->rowCount();

//check id more than 0 record found
if ($num > 0) {
    // product array
    $product_arr = array();
    $product_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );
        array_push($product_arr["records"], $product_item);
    }

    http_response_code(200);

    echo json_encode($product_arr);
} else{
    http_response_code(404);
  
    echo json_encode(
        array("message" => "No products found.")
    );
}