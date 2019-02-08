<?php

namespace app\componentes;


class FormHelpers{

  public static function cleanInput($inputName,$allow=FALSE){

    /**
     * Retira todos os espaços multiplos em branco caso
     * sencitive.
     */
    $pattern = "/\s\s+/i";
    $inputName = preg_replace($pattern, '', $inputName);
    
    // Retira todas as tags HTML exeto as $allow
    $inputName = strip_tags($inputName,$allow);
    
    return $inputName;

  }
  /**
   * Método indicado ao uso quando for gravar entradas de dados
   * no Database e quando for mostra-las.
   */
  public static function sanitizeInput($varName){
      
    $pattern = "/(\'?\"?\??\*?\#?)*|(-{2})?/";
    $varName = preg_replace($pattern, '', $varName);
        
    return self::cleanInput($varName);

  }

  public static function getCode($length){

    // Letras utilizadas para gerar o código (não usamos todas as letras porque algumas causam confusão...)
    $letras = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');

    for( $k=0; $k <= $length; $k++ ) { 
        
      $code = NULL;
      $i = 1;
      
      // Gera um code - Número + Letra + Número + Letra + Número + Letra + Número
      // Gera um dígito numérico nas posições ímpares (não utilizamos os números 0 e 1)
      while($i <= $length) {
        $code .= ($i % 2 != 0) ? mt_rand(1, 9) : $letras[mt_rand(0, 21)];
        $i++;
      }           
                                        
    }
    
    return $code;

  }

  public static function compareCode($code1, $code2){
              
    if(self::sanitizeInput($code1) === self::sanitizeInput($code2)){
      return TRUE;
    }

    return FALSE;

  }

}