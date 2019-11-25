<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//get database connection
include_once '../config/connection.php';

//instantiate product object
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

//get posted data
$data = json_decode(file_get_contents("php://input"));

//make sure data is not empty
if(
  !empty($data->name) &&
  !empty($data->price) &&
  !empty($data->description) &&
  !empty($data->category_id)
){
  //set product property values
  $product->name = $data->name;
  $product->price = $data->price;
  $product->description = $data->description;
  $product->category_id = $data->category_id;
  $product->created = date('Y-m-d H:i:s');

  //create product
  if($product->create()){
    //set response code to 201, what means created
    http_response_code(201);

    //tell the user
    echo json_encode(array("message" => "Product was created."));
  }
  //if unable to create product, tell the user
  else{
    //set response code 503 - service unavailable
    http_response_code(503);

    //tell the user
    echo json_encode(array("message" => "Unable to create product."));
  }
}
//if the data is incomplete
else {
  //se response code to 400 - bad request!
  http_response_code(400);

  //tell the user
  echo json_encode(array("message" => "Unable to create product. Data is incomplete"));
}
