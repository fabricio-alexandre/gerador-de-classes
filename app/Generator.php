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

  /**
   * Diretorio dos arquivos gerados
   * @var string
   */
  const PATH_OUTPUT = __DIR__.'/../files';

  /**
   * Diretorio dos arquivos de template
   * @var string
   */
  const PATH_TEMPLATES = __DIR__.'/../templates';

  /**
   * Caminho do arquivo a ser gerado
   * @var string
   */
  protected $filename = null;

  /**
   * Nome da classe
   * @var string
   */
  protected $className = null;

  /**
   * Descrição da classe
   * @var string
   */
  protected $description = null;

  /**
   * Pacote
   * @var string
   */
  protected $package = null;

  /**
   * Author da classe
   * @var string
   */
  protected $author = null;

  /**
   * Propriedades da classe
   * @var array
   */
  protected $properties = [];


  /**
   * Responsavel por criar uma classe
   * @method buildClass
   * @param  array   $tableDetails
   * @param  string  $package
   * @param  string  $author
   * @return string
   */
  public function buildClass(array $tableDetails, $package, $author){
    $this->setAttributes($tableDetails, $package, $author)
         ->buildHeader()
         ->buildBeginClass()
         ->buildProperties()
         ->buildGetProperties()
         ->buildEndClass()
         ->setPermission();
    return $this->filename;
  }


  /**
   * Seta os atributos no Generator
   * @method setAttributes
   * @param  array   $tableDetails
   * @param  string  $package
   * @param  string  $author
   * @return this
   */
  protected function setAttributes(array $tableDetails, $package, $author){
    if (!self::validateData($tableDetails)) return self::setErro('Dados inválidos');
    $this->className   = $tableDetails['className'];
    $this->filename    = self::PATH_OUTPUT.'/'.$this->className.'.php';
    $this->description = $tableDetails['description'];
    $this->properties  = $tableDetails['properties'];
    $this->package     = $package;
    $this->author      = $author;
  }


  /**
   * Valida se os dados de entrada são válidos
   * @method validateData
   * @param  array $tableDetails
   * @return bool
   */
  public function validateData($tableDetails){
    return (
      isset($tableDetails['className']) and
      strlen($tableDetails['className']) and
      isset($tableDetails['description']) and
      isset($tableDetails['properties']) and
      is_array($tableDetails['properties'])
    );
  }


  /**
   * Valida se o caminho do arquivo de template é valido
   * @method validateFile
   * @param  string  $file
   * @return bool
   */
  public function validateFile($file){
    if (file_exists($file)) return true;
    return $this->setErro('Arquivo de template inexistente "'.$file.'"');
  }


  /**
   * Imprime uma mensagem de erro e interrompe o processo
   * @method setErro
   * @param  string  $mensagem
   * @return void
   */
  public function setErro($mensagem){
    die('Erro: '.$mensagem);
  }


  /**
   * Constroi o topo da classe
   * @method buildHeader
   * @return this
   */
  protected function buildHeader(){
    $fileTemplate = self::PATH_TEMPLATES.'/header';
    $this->validateFile($fileTemplate);
    
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


  /**
   * Constroi a abertura da classe
   * @method buildBeginClass
   * @return this
   */
  protected function buildBeginClass(){
    $fileTemplate = self::PATH_TEMPLATES.'/begin-class';
    $this->validateFile($fileTemplate);

    $content = file_get_contents($fileTemplate);
    file_put_contents($this->filename, Funcoes::getValuesVariables(['className' => $this->className], $content), FILE_APPEND);
    return $this;
  }


  /**
   * Constroi as propriedades da classe
   * @method buildProperties
   * @return this
   */
  protected function buildProperties(){
    $fileTemplate = self::PATH_TEMPLATES.'/property';
    $this->validateFile($fileTemplate);

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


  /**
   * Constroi o metodo getProperties() presente nas classes
   * @method buildGetProperties
   * @return this
   */
  protected function buildGetProperties(){
    $fileTemplate = self::PATH_TEMPLATES.'/get-properties';
    $this->validateFile($fileTemplate);
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


  /**
   * Constroi o fechamento da classe
   * @method buildEndClass
   * @return this
   */
  protected function buildEndClass(){
    $fileTemplate = self::PATH_TEMPLATES.'/end-class';
    $this->validateFile($fileTemplate);

    $content = file_get_contents($fileTemplate);
    file_put_contents($this->filename, Funcoes::getValuesVariables([], $content), FILE_APPEND);
    return $this;
  }


  /**
   * Seta permissao para outros usuarios na classe
   * @method setPermission
   * @return void
   */
  public function setPermission(){
    chmod($this->filename, 0777);
  }

}