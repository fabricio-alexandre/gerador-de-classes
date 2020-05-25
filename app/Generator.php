<?php
/**
 * 
 * class Generator
 * 
 * Responsavel por gerar os arquivos das classes
 * 
 * @package GeradorDeClasses
 * 
 * @author Fabricio Alexandre
 * 
 */

namespace App;

class Generator {

  const PATH_OUTPUT = __DIR__.'/../files';

  const PATH_TEMPLATES = __DIR__.'/../templates';

  protected $filename = null;

  protected $className = null;

  protected $description = null;

  protected $package = null;

  protected $author = null;

  protected $properties = [];


  public function buildClass(array $tableDetails, $package, $author){
    $this->setAttributes($tableDetails, $package, $author);
    $this->buildHeader()->buildBeginClass()->buildProperties()->buildGetProperties()->buildEndClass()->setPermission();
    return $this->filename;
  }


  public function setAttributes(array $tableDetails, $package, $author){
    if (!self::validarDados($tableDetails)) return self::setErro('Dados inválidos');
    $this->className   = $tableDetails['className'];
    $this->filename    = self::PATH_OUTPUT.'/'.$this->className.'.php';
    $this->description = $tableDetails['description'];
    $this->properties  = $tableDetails['properties'];
    $this->package     = $package;
    $this->author      = $author;
  }


  public function buildHeader(){
    $fileTemplate = self::PATH_TEMPLATES.'/header';
    $this->validarArquivo($fileTemplate);
    
    $var = [
      'className'   => $this->className,
      'description' => $this->description,
      'package'     => $this->package,
      'author'      => $this->author,
    ];
    $content = file_get_contents($fileTemplate);
    file_put_contents($this->filename, Funcoes::getValuesVariables($var, $content));
    return $this;
  }


  public function buildBeginClass(){
    $fileTemplate = self::PATH_TEMPLATES.'/begin-class';
    $this->validarArquivo($fileTemplate);

    $content = file_get_contents($fileTemplate);
    file_put_contents($this->filename, Funcoes::getValuesVariables(['className' => $this->className], $content), FILE_APPEND);
    return $this;
  }


  public function buildProperties(){
    $fileTemplate = self::PATH_TEMPLATES.'/property';
    $this->validarArquivo($fileTemplate);

    $content = file_get_contents($fileTemplate);
    foreach ($this->properties as $key => $property) {
      $var = [
        'comment'  => $property->comment,
        'property' => Funcoes::getCamelCase($property->column, '_'),
        'value'    => "null",
      ];
      file_put_contents($this->filename, Funcoes::getValuesVariables($var, $content), FILE_APPEND);
    }
    return $this;
  }


  public function buildGetProperties(){
    $fileTemplate = self::PATH_TEMPLATES.'/get-properties';
    $this->validarArquivo($fileTemplate);
    $content = file_get_contents($fileTemplate);

    $var = ['propertyList' => null];
    foreach ($this->properties as $key => $property) {
      $property->property = Funcoes::getCamelCase($property->column, '_');
      // ESPAÇO NO COMEÇO
      if ($key > 0) $var['propertyList'] .= "      ";
      // PROPRIEDADE
      if (isset($property->column)) $var['propertyList'] .= "'".$property->property."' => '".$property->column."',";
      // ESPAÇO NO FINAL
      if (isset($this->properties[$key+1])) $var['propertyList'] .= "\n";
    }

    file_put_contents($this->filename, Funcoes::getValuesVariables($var, $content), FILE_APPEND);
    return $this;
  }


  public function buildEndClass(){
    $fileTemplate = self::PATH_TEMPLATES.'/end-class';
    $this->validarArquivo($fileTemplate);

    $content = file_get_contents($fileTemplate);
    file_put_contents($this->filename, Funcoes::getValuesVariables([], $content), FILE_APPEND);
    return $this;
  }


  public function validarDados($tableDetails){
    return (
      isset($tableDetails['className']) and
      strlen($tableDetails['className']) and
      isset($tableDetails['description']) and
      isset($tableDetails['properties']) and
      is_array($tableDetails['properties'])
    );
  }


  public function validarArquivo($file){
    if (file_exists($file)) return true;
    $this->setErro('Arquivo de template inexistente "'.$file.'"');
  }

  public function setErro($mensagem){
    die('Erro: '.$mensagem);
  }


  public function setPermission(){
    chmod($this->filename, 0777);
  }

}