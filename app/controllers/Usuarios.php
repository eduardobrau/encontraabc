<?php

namespace app\controllers;

use app\models\Usuario;
use core\View; 
use app\componentes\ErrorLog;

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
    $Usuario = new Usuario;
    $usuarios = $Usuario->index();
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

  public function create($params=null){    
    
    if( $_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['USUARIO']) ):
      
      $Usuario = new Usuario;
      
      if( $usuario = $Usuario->create($_POST['USUARIO']) ):
        return $this->View->load('info/sucesso',$usuario);
      else: 
        $data = [
          'title' => 'Não foi possível salvar os dados',
          'msg'   => 'Por favor contactar o administrador do sistema'
        ];
        return $this->View->load('erro/error', $data);
      endif;

    endif;
    
    return $this->View->load('usuarios/create');    
   
  }

  public function edit($params){

    if($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_GET['id'])): 

      $Usuario = new Usuario;
      /**
       * showUser retorna todos os dados do usuário
       * em caso de sucesso, e caso não exista ou
       * houver um erro de SQL retornará FALSE.
       */
      if( $usuario = $Usuario->showUser($params['id']) ):        
        return $this->View->load('usuarios/create',$usuario);
      endif;
      
    endif;

  }

  public function delete($params=null){
    
    if( $_SERVER['REQUEST_METHOD'] === 'GET' and isset($_GET['id']) ):

      $Usuario = new Usuario;

      if( $userArray = $Usuario->delete($params['id']) ):        
        //return $jSONusuario;
        echo "<pre>"; print_r($jSONusuario); echo "</pre>";die;
        
      endif;
    
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['id'])):
      
      $Usuario = new Usuario;
      
      if( $userArray = $Usuario->delete($_POST['id']) ):        
        
        echo json_encode($userArray);
        die();
        
      endif;

    endif;

  }


}