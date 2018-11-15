<?php

namespace app\controllers;
use app\models\Usuario;
use core\View;

class Usuarios{

  public function __construct($action,$params){
    $this->$action($params);
  }

  public function index($params=null){
    $usuario = new Usuario;
    $this->View = new View;
    $usuarios = $usuario->index();
    //echo "<pre>"; print_r($usuarios); echo "</pre>";die;
    $this->View->load('usuarios/index', $usuarios);
  }

  public function view($params){
    $usuario = new Usuario;
    $this->View = new View;
    $usuarios = $usuario->view($params['id']);
    //echo "<pre>"; print_r($params); echo "</pre>";die;
    $this->View->load('usuarios/view', $usuarios);
  }


}