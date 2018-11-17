<?php

namespace app\controllers;
use app\models\Usuario;
use core\View;

class Usuarios{
  /**
   * Ao instanciar este controller inicio
   * a instância da classe View, visto que
   * se o script chegou até aqui deverá mostrar algo.
   */
  public function __construct($action,$params){
    if( method_exists($this,$action) ):
      $this->View = new View;
      $this->$action($params);
    else:
      throw new \Exception("[Error:] Pagina não encontrada");
    endif;
  }

  public function index($params=null){
    $usuario = new Usuario;
    $this->View = new View;
    $usuarios = $usuario->index();
    //echo "<pre>"; print_r($usuarios); echo "</pre>";die;
    $this->View->load('usuarios/index', $usuarios);
  }

  public function view($params){    
    $Usuario = new Usuario;
    $usuarios = $Usuario->view($params['id']);
    //echo "<pre>"; print_r($usuarios); echo "</pre>";
    if($usuarios):
      $this->View->load('usuarios/view', $usuarios);
    else:
      $this->View->load('erro/error', $usuarios);
    endif;
  }


}