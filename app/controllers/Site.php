<?php

namespace app\controllers;

use app\models\LoginForm;
use core\View;
use app\componentes\Login;

class Site{

  /**
   * Ao instanciar este controller inicio
   * a instância da classe View, visto que
   * se o script chegou até aqui deverá mostrar algo.
   */
  public function __construct($action,$params){

    $this->View = new View;

    if( method_exists($this,$action) ):
      $this->$action($params);
    else:
      $data = [
        'title' => 'Not Found => (Página Não Encontrada!)',
        'msg'   => 'Por favor verifique a página digitada e tente novamente.'
      ];
      return $this->View->load('erro/error', $data);
    endif;

  }
  
  public function login(){
    if( $_SERVER['REQUEST_METHOD'] === 'POST' and !empty($_POST['LoginForm']['email']) 
    or !empty($_POST['LoginForm']['password']) ):
    
      $email = $_POST['LoginForm']['email'];
      $password =  $_POST['LoginForm']['password'];
      
      // Retorna TRUE ou FALSE
      if( LoginForm::logar($email,$password) ){
        header('Location: admin/index');
      }

      $data = [
        'title' => 'Erro Login => (Página Não Encontrada!)',
        'msg'   => 'Por favor verifique a página digitada e tente novamente.'
      ];

      return $this->View->load('erro/error', $data);
      
    endif;
  }

  public function logout(){
    if(Login::isLogged()){
      Login::logout();
    }
  }

}