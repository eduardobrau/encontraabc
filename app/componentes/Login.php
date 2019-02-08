<?php

namespace app\componentes;

use app\componentes\DB;
use app\componentes\FormHelpers;
use app\componentes\ErrorLog;


Class Login{

  private static $DB;
 
  public static function startSession(){
    //Verificar se a sessão não já está aberta.
    if ( session_status() !== PHP_SESSION_ACTIVE ) {
      return session_start();
    }
  }

  public static function isLogged(){
      
    self::startSession();
    
    if( !empty($_SESSION['logado']) and $_SESSION['logado'] === true ){
      return TRUE;
    }
      
  }

  public static function login($email,$senha){
      
    $email = FormHelpers::sanitizeInput($email);
    $senha = FormHelpers::sanitizeInput($senha);
        
    try{
      
      if( empty($DB) ){
        self::$DB = new DB();
      }    
          
      $row = self::$DB->view('usuarios','*','WHERE email = \''.$email.'\' ');
                     
      if(self::$DB->getNumRows() == 1):
        
        if( !password_verify($senha,$row['senha']) ){
          return FALSE;
        }
        
        $id = FormHelpers::sanitizeInput($row['id']);
        $email = FormHelpers::sanitizeInput($row['email']);

        self::startSession();

        $_SESSION['id_usuario'] = $id;
        $_SESSION['usuario'] = $row['usuario'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['logado'] = TRUE;
        
        return TRUE;

      endif;
        
      return FALSE;

    }catch(\Exception $e){

      $error = $e->getMessage() .  
      ' do arquivo ' . $e->getFile() .  
      ' na linha ' . $e->getLine() .
      ' erro capturado no arquivo ' .__FILE__.
      ' da linha ' .__LINE__. '';

      $ErrorLog = new ErrorLog;
      $ErrorLog->writeLog($error);

    } 
      
  }

  public static function getIdUsuario(){
    self::startSession();
    return $_SESSION['id_usuario'];
  }

  public static function logout(){
    self::startSession();
    unset($_SESSION['id_usuario'],$_SESSION['logado']);
    session_destroy();
    return TRUE;
    header("Location: /index");
  }

}