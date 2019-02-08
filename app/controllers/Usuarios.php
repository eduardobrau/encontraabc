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
    
    if( $_SERVER['REQUEST_METHOD'] === 'POST' and !empty($_POST['USUARIO']) ):
      
      $Usuario = new Usuario;
      // Caso as sessões não estejam habilita e nenhuma existir, inicio uma nova.
      if( session_status() !== PHP_SESSION_ACTIVE ): 
        session_start();
      endif;
      /**
       * Caso esteja setada sei que houve um refresh da template sucesso,
       * e impesso que os dados já setados via $_POST seja inseridos novamente.
       */               
      if( empty($_SESSION['id']) ):
        
        if( $usuario = $Usuario->create($_POST['USUARIO']) ):                            
          return $this->View->load('info/sucesso',$usuario);
        else: 
          $data = [
            'title' => 'Não foi possível salvar os dados',
            'msg'   => 'Por favor contactar o administrador do sistema.'
          ];          
          return $this->View->load('erro/error', $data);
        endif;
        /**
         * Destruo a sessão atual, isso não limpa os dados já gravados
         * da requisição atual, isso só vai ocorrer em uma nova requisição
         * ao servidor, e neste caso quando eu redirecionar para index.
         */  
      else: 
        unset($_SESSION['id']);
        header('Location: /usuarios/index');
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
      if( $usuario = $Usuario->edit($params['id']) ):        
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