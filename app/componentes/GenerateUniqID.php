<?php

namespace app\componentes;

use app\componentes\DB;
use app\componentes\ErrorLog;

class GenerateUniqID{

       
  public function __construct(){

    try{
      $this->DB = new DB;
    }catch(Exception $e){
      $error = $e->getMessage() . 
      ' do arquivo '. $e->getFile() . 
      ' na linha ' . $e->getLine() .
      ' erro capturado no arquivo ' . __FILE__ . 
      ' da linha ' . __LINE__ . '';
      $ErrorLog = new ErrorLog;
      $ErrorLog->writeLog($error);
      return FALSE;
    }

  }

  public function getId(){
  
    return $this->generateUniqueRandomInt();

  }

  public function generateRandomDigits($length){
    /**
     * Cria um array contendo uma faixa de elementos
     * de 1 até 10. Obs: $number[0]=1, $number[1]=2...
     * ou seja um array com valores de 1 até 10
     * 82.993.310.410.649.151
     * 9.223.372.036.854.775.807
     */
    $numbers = range(1,10);
    //echo "<pre>"; print_r($numbers); echo "</pre>";
    
    $digits = NULL;
    for($i = 0; $i < $length; $i++):
      //Essa função mistura de forma aleatória os elementos de um array.
      shuffle($numbers);
      /**
       * Pego o valor do array de forma aleatória no 
       * range de seus indices variando de 0 até 9
       */
      $digits .= $numbers[rand(0,9)];
    endfor;
      //echo "<pre>"; var_dump($digits); echo "</pre>";die;
    return (int)$digits;

  }

  public function generateUniqueRandomInt($length = 15) {
			
    $randomDigit = $this->generateRandomDigits($length);
    //echo "<pre>"; print_r($randomDigit); echo "</pre>";die;
    $this->DB->consultar('usuarios','`id`','id='.$randomDigit.''); 
    // Se não houver usuarios com o id gerado retorna $randomDigit
    if(!$this->DB->getNumRows())
      return $randomDigit;
    else
      return $this->generateUniqueRandomInt($length);
        
  }

  public function generateUniqueRandomString($attribute, $length = 32) {
			
    $randomString = Yii::$app->getSecurity()->generateRandomString($length);
        
    if(!$this->findOne([$attribute => $randomString]))
      return $randomString;
    else
      return $this->generateUniqueRandomString($attribute, $length);
        
  }


}