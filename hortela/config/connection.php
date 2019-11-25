<?php
class Database
{

  //especificar as minhas credenciais
  private $host = "localhost:3306";
  private $db_name = "hortela_teste";
  private $username = "hortelaAdmin";
  private $password = "senTa1&pa@#$";
  private $link;

  //busca a conexão da base de dados
  public function __construct()
  {
    try {
      $this->link = mysqli_connect($host, $username, $password, $db_name);
    } catch (PDOException $exception) {
      echo "Connection error: $exception->getMessage()";
    }
    return $this->conn;
  }

  public function close()
  {
    mysqli_close($link);
  }
}
