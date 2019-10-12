<?php
    http_response_code(200);

    $response=array(
          "id" => "id",
          "name" => "nomeProd",
          "description" => "Descruption",
          "price" => "10",
          "category_id" => "idCat",
          "category_name" => "nomecat"
    );
      
    echo json_encode($response);
?>