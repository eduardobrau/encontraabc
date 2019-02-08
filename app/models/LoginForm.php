<?php

namespace app\models;

use app\componentes\Login;

class LoginForm{

  public static function logar($email,$password){

    if( Login::isLogged() ){
      return TRUE;
    }
    /**
     * Retorna TRUE ou FALSE em caso TRUE inicia uma sessão
     * em caso de ainda não houver uma ativa e seta as
     * $_SESSION['id_usuario'] e $_SESSION['logado']
     */
    return $result = Login::login($email,$password);   

  }

}