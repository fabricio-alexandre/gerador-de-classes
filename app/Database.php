<?php
/**
 * 
 * class Database
 * 
 * Gerencia a conexão dos dados com o banco
 * 
 * @package GeradorDeClasses
 * 
 * @author Fabricio Alexandre
 * 
 */

namespace App;

use App\Funcoes;
use PDO;
use PDOException;

class Database {
  
  /**
   * Host
   * @var string
   */
  private $host = null;

  /**
   * Porta
   * @var int
   */
  private $port = null;

  /**
   * Usuario
   * @var string
   */
  private $user = null;

  /**
   * Senha
   * @var string
   */
  private $pass = null;

  /**
   * Nome do banco
   * @var string
   */
  private $dbName = null;
  
  
  public function __construct($host, $port, $user, $pass, $dbName){
    $this->host   = $host;
    $this->port   = $port;
    $this->user   = $user;
    $this->pass   = $pass;
    $this->dbName = $dbName;
    return $this;
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

  public function connect(){
    try {
      $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbName.';port='.$this->port.';charset=utf8';
      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => true
      ];
      return new PDO($dsn, $this->user, $this->pass, $options);
    } catch (PDOException $e) {
      echo 'Erro de conexão: ' . $e->getMessage();
    }
  }


  public function query($query){
    $connect = $this->connect();
    try{
			$connect->beginTransaction();
			$result = $connect->query($query);
			$connect->commit();
		} catch (PDOException $e) {
      $connect->rollBack();
			$result = NULL;
      $message = 'Erro na execução da query (%d): %s';
      die(sprintf($message, $e->errorInfo[1], $e->getMessage()));
    }
    return $result;
  }


  public function getTableDetails(array $tables){
    $return = [];
    foreach ($tables as $key => $table) {
      if (!isset($table['name']) or !isset($table['description'])) continue;
      $return[$key] = [
        'className'   => ucfirst(Funcoes::getCamelCase($table['name'], '_')),
        'description' => $table['description'],
        'properties'  => $this->getColumnDetails($table['name'])
      ];
    }
    return $return;
  }


  public function getColumnDetails($tableName){
    $query = 'SELECT 
              a.TABLE_NAME AS "table",
              a.COLUMN_NAME AS "column", 
              a.COLUMN_COMMENT AS "comment"
              FROM information_schema.`COLUMNS` a
              WHERE a.TABLE_SCHEMA = "'.$this->dbName.'" AND a.TABLE_NAME = "'.$tableName.'"';
    return $this->query($query)->fetchAll(PDO::FETCH_CLASS);
  }

}

