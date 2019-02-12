<?php

namespace app\controllers;

use app\models\Cidade;
use core\View;
use app\componentes\ErrorLog;

class Cidades{
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
    $Cidade = new Cidade;
    $this->View = new View;
    $cidades = $Cidade->index();
    //echo "<pre>"; print_r($cidades); echo "</pre>";die;
    $this->View->load('cidades/index', $cidades);
  }

  public function view($params){    
    $Cidade = new Cidade;
    $cidades = $Cidade->view($params['id']);
    //echo "<pre>"; print_r($cidades); echo "</pre>";
    if($cidades):
      $this->View->load('cidades/view', $cidades);
    else:
      $this->View->load('erro/error', $cidades);
    endif;
  }

  public function create($params=null){    
        
    if( $_SERVER['REQUEST_METHOD'] === 'POST' and !empty($_POST['Cidade']) ):
      
      // Caso as sessões não estejam habilita e nenhuma existir, inicio uma nova.
      if( session_status() !== PHP_SESSION_ACTIVE ): 
        session_start();
      endif;
      
      /**
       * Caso esteja setada sei que houve um refresh da template sucesso,
       * e impesso que os dados já setados via $_POST seja inseridos novamente.
       * Como sei se há cada refresh os dados estão sendo inseridos novamente?
       * para isso basta colar o seguinte código abaixo da linha 103 de create() 
       * echo "<pre>"; print_r(rand(0,100)); echo "</pre>";
       */   
      if( empty($_SESSION['idSaved']) ):

        $Cidade = new Cidade;

        try{
          /***
           * create() retorna um array com os dados retornado de view()
           * ou FALSE caso o registro não foi inserido, seja por validação.
           */         
          if( $Cidade = $Cidade->create($_POST['Cidade']) ):                
            return $this->View->load('info/sucesso',$Cidade);
          else:
            $data = [
              'title' => 'Não foi possível salvar os dados',
              'msg'   => 'Por favor contactar o administrador do sistema.'
            ];
            return $this->View->load('erro/error', $data);
          endif;

        }catch(\Exception $e){

          $error = $e->getMessage() . 
            ' do arquivo '. $e->getFile() . 
            ' na linha ' . $e->getLine() .
            ' erro capturado no arquivo ' . __FILE__ . 
            ' da linha ' . __LINE__ . '';
          $ErrorLog = new ErrorLog;
          $ErrorLog->writeLog($error);

          $data = [
            'title' => 'Erro de validação!',
            'msg'   => $e->getMessage(),
          ];
          return $this->View->load('erro/error', $data);
        }      
        /**
         * Destruo a variável de SESSION['id'] especifica 
         * na $_SESSION atual, isso só vai ocorrer em uma nova requisição
         * ao servidor, e neste caso quando eu redirecionar para index.
         */  
      else: 
        unset($_SESSION['idSaved']);
        header('Location: /cidades/index');
      endif;

    endif;
    
    return $this->View->load('cidades/create');    
   
  }

  public function edit($params){

    if($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_GET['id'])): 

      $Cidade = new Cidade;
      /**
       * edit retorna todos os dados do usuário
       * em caso de sucesso, e caso não exista ou
       * houver um erro de SQL retornará FALSE.
       */
      if( $Cidade = $Cidade->edit($params['id']) ):                
        return $this->View->load('cidades/create',$Cidade);
      else:
        $this->View->load('erro/error');
      endif;
      
    endif;

  }

  public function delete($params=null){
    
    if( $_SERVER['REQUEST_METHOD'] === 'GET' and isset($_GET['id']) ):

      $Cidade = new Cidade;

      if( $userArray = $Cidade->delete($params['id']) ):        
        //return $jSONCidade;
        echo "<pre>"; print_r($userArray); echo "</pre>";die;
        
      endif;
    
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['id'])):
      
      $Cidade = new Cidade;
      
      if( $userArray = $Cidade->delete($_POST['id']) ):        
        
        echo json_encode($userArray);
        die();
        
      endif;

    endif;

  }


}