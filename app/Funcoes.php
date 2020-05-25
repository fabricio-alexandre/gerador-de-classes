<?php
/**
 * 
 * class Funcoes
 * 
 * Fornece funcoes auxiliares ao sistema
 * 
 * @package GeradorDeClasses
 * 
 * @author Fabricio Alexandre
 * 
 */

namespace App;

class Funcoes {

  /**
   * Transforma uma string em camelCase
   * @method getCamelCase
   * @param  string $string
   * @param  string $separator
   * @return string
   */
  public static function getCamelCase($string, $separator){
    if (!strlen($separator)) return $string;
    $xString = explode($separator, $string);
    $return  = null;
    foreach ($xString as $key2 => $value2) {
      $return .= ($key2 > 0) ? (ucfirst($value2)) : ($value2);
    }
    return $return;
  }


  /**
   * Atribui valores às variaveis em uma string com {}
   * @method getValuesVariables
   * @param  array  $values
   * @param  string $str
   */
  public static function getValuesVariables($values, $str){
    foreach($values as $key => $value){
      $str = str_replace('{'.$key.'}', $value, $str);
    }
    return $str;
  }

}