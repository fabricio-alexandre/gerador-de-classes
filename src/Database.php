<?php
namespace App;

class Database {

  // public $conexao;
  
  // public function query($query){
  //   $connect = conectar();
  //   $connect->beginTransaction();
  //   $result = $connect->query($query);
  //   $connect->commit();
  //   return $result;
  // }
  
  
  // public function __construct($host, $port, $user, $pass, $dbName){
  public function __construct(){
    echo "<pre>"; print_r('chegou'); echo "</pre>"; exit;
    // if (!$this->conexao instanceOf \PDO) {
    //   try {
    //     $porta = strlen($port) ? ';port='.$port : null;
    //     $dsn = 'mysql:host='.$host.';dbname='.$dbName.$porta.';charset=utf8';
    //     $options = [
    //       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //       PDO::ATTR_PERSISTENT => true
    //     ];

    //     $this->conexao = new PDO($dsn, $user, $pass, $options);
    //   } catch (\PDOException $e) {
    //     echo 'Erro de conexão: ' . $e->getMessage();
    //   }
    // }
  }

}

