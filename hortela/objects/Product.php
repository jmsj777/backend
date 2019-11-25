<?php
class Product{
 
  // database connection and table name
  private $connection;
  private $table_name = "produto";

  // object properties
  public $id;
  public $nome;
  public $descricao;
  public $preco;
  
  // constructor with $db as database connection
  public function __construct($db){
    $this->connection = $db;
  }

  // read products
  function read(){
  
    // select all query
    $query = "SELECT
                p.id, p.nome, p.descricao, p.preco, p.category_id, p.created
            FROM
                $this->table_name p
            ORDER BY
                p.nome DESC";

    // prepare query statement
    $stmt = $this->connection->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
  }

  // used when filling up the update product form
  function readOne(){
  
    // query to read single record
    $query = "SELECT
                p.id, p.nome, p.descricao, p.preco, p.category_id, p.created
              FROM $this->table_name p
              WHERE p.id = ?
              LIMIT 0,1";

    // prepare query statement
    $stmt = $this->connection->prepare( $query );

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
    $this->nome = $row['nome'];
    $this->preco = $row['preco'];
    $this->descricao = $row['descricao'];
  }

  // create product
  function create(){

    // sanitize
    $this->nome=htmlspecialchars(strip_tags($this->nome));
    $this->preco=htmlspecialchars(strip_tags($this->preco));
    $this->descricao=htmlspecialchars(strip_tags($this->descricao));
    
    // query to insert record
    $query = "INSERT INTO $this->table_name SET
                nome='$this->nome', 
                preco=$this->preco, 
                descricao='$this->descricao', 
              ;";

    // prepare query
    $stmt = $this->connection->prepare($query);
    
    // bind values - I took it off because the new paradigm can do it better!
    // $stmt->bindParam(":nome", $this->nome);
    // $stmt->bindParam(":preco", $this->preco);
    // $stmt->bindParam(":descricao", $this->descricao);
    // $stmt->bindParam(":category_id", $this->category_id);
    // $stmt->bindParam(":created", $this->created);
 
    // var_dump($stmt);
    // execute query
    $resposta = $stmt->execute();

    if($resposta) return true;
    else          return false;
  }

  // update the product
  function update(){
  
    // query to read single record
    $query = "SELECT p.id, p.nome
              FROM $this->table_name p
              WHERE p.id = ?
              LIMIT 0,1";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // return 202 (not found) if not found
    if($row==false){
      return 202;
    }
    // update query
    $query = "UPDATE $this->table_name SET
                nome = :nome,
                preco = :preco,
                descricao = :descricao
            WHERE
                id = :id";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->nome=htmlspecialchars(strip_tags($this->nome));
    $this->preco=htmlspecialchars(strip_tags($this->preco));
    $this->descricao=htmlspecialchars(strip_tags($this->descricao));
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind new values
    $stmt->bindParam(':nome', $this->nome);
    $stmt->bindParam(':preco', $this->preco);
    $stmt->bindParam(':descricao', $this->descricao);
    $stmt->bindParam(':id', $this->id);

    // execute the query
    if($stmt->execute()){
        return 200;
    }

    return 503;
  }

  function delete(){

    // query to read single record
    $query = "SELECT p.id, p.nome
              FROM $this->table_name p
              WHERE p.id = ?
              LIMIT 0,1";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // return 202 (not found) if not found
    if($row==false){
      return 202;
    }
    
    // delete query
    $query = "DELETE FROM $this->table_name WHERE id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
  }

  // search products
  function search($keywords){
  
    // select all query
    $query = "SELECT
                p.id, p.nome, p.descricao, p.preco, p.category_id, p.created
            FROM $this->table_name p
            WHERE
                p.nome LIKE ? OR p.descricao LIKE ?
            ORDER BY
                p.nome DESC";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $keywords = htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";

    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);

    // execute query
    $stmt->execute();

    return $stmt;
  }
}
