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
  
  /**
   * Construtor da classe
   * @method __construct
   * @param string  $host
   * @param string  $port
   * @param string  $user
   * @param string  $pass
   * @param string  $dbName
   */
  public function __construct($host, $port, $user, $pass, $dbName){
    $this->host   = $host;
    $this->port   = $port;
    $this->user   = $user;
    $this->pass   = $pass;
    $this->dbName = $dbName;
    return $this;
  }


  /**
   * Responsavel pela conexao com o banco de dados
   * @method connect
   * @return PDO
   */
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


  /**
   * Executa uma query no banco de dados
   * @method query
   * @param  string $query
   * @return PDOStatement
   */
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


  /**
   * Obtem os detalhes de uma tabela
   * @method getTableDetails
   * @param  array  $tables
   * @return array
   */
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


  /**
   * Retorna os detalhes de uma coluna
   * @method getColumnDetails
   * @param  string  $tableName
   * @return array
   */
  public function getColumnDetails($tableName){
    $query = 'SELECT 
              a.TABLE_NAME AS "table",
              a.COLUMN_NAME AS "column", 
              a.DATA_TYPE AS "dataType", 
              a.COLUMN_COMMENT AS "comment"
              FROM information_schema.`COLUMNS` a
              WHERE a.TABLE_SCHEMA = "'.$this->dbName.'" AND a.TABLE_NAME = "'.$tableName.'"';
    return $this->query($query)->fetchAll(PDO::FETCH_CLASS);
  }

}

