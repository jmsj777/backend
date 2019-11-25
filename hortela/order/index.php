<?php

require_once '../objects/Order.php';

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$base = '/hortela/order';

$order = new Order();

switch ($method) {
  case "GET":

    switch ($request) {
      case $base:

        echo $order->read(null);
        break;
    }
    break;
  case "POST":
    switch ($request) {
      case $base:
        $order = new Order(
          $_POST['name'],
          $_POST['nomeProd'],
          $_POST['cliente'],
          $_POST['dataPedido'],
          $_POST['dataMarcada']
        );

        echo json_encode($order);
        break;
    }
}
