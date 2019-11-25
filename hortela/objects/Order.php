<?php
class Order
{

  // database connection and table name
  // private $conn;
  private $table_name = "pedido";

  // object properties
  public $id;
  public $nomeProd;
  public $cliente;
  public $dataPedido;
  public $dataMarcada;

  public function __construct(
    $id = '',
    $nomeProd = 'default',
    $cliente = 'default',
    $dataPedido = '',
    $dataMarcada = ''
  ) {
    $this->id = $id;
    $this->nomeProd = $nomeProd;
    $this->cliente = $cliente;
    $this->dataPedido = $dataPedido;
    $this->dataMarcada = $dataMarcada;
  }

  public function read($id)
  {
    if (!$id) {
      return json_encode($this);
    } else { }
  }
}
