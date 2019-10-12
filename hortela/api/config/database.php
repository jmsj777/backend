<?php
class Database {

  //especificar as minhas credenciais
  private $host = "localhost:3306";
  private $db_name = "hortela";
  private $username = "hortelaAdmin";
  private $password = "senTa1&pa@#$";
  public $conn;

  //busca a conexão da base de dados
  public function getConnection(){
    $this->conn = null;

    try{
      $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
      $this->conn->exec("set names utf8");
    }catch(PDOException $exception){
      echo "Connection error: $exception->getMessage()";
    }
    return $this->conn;
  }
}
?>