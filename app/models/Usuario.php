<?php

namespace app\models;

use app\componentes\DB;
use app\componentes\Paginacao;
use app\componentes\DataValidator;
use app\componentes\DataHash;
use app\componentes\ErrorLog;
use app\componentes\GenerateUniqID;

class Usuario{

  private $DB;

  public function __construct(){
    $this->DB = new DB();
  }

  public function index(){

    $Paginacao = new Paginacao(10);
    /**
     * Retorna todos os candidatos conforme uma consulta
     * SQL necessária para setar
     */
    $usuarios = $Paginacao->showDatas(
      'usuarios',$campos=FALSE, $where=FALSE,
      $like=FALSE, $order='data_cadastro DESC'
    );
    $Paginacao->totalItens('usuarios','id');
    $nav = $Paginacao->renderNav();
    return ['usuarios' => $usuarios, 'nav' => $nav];

  }

  public function view($id){
    /**
     * Método consultar() é possível de erro
     * então trato essa possível falha capturando
     * o erro para mais tarde implementar um log,
     * por enquanto apenas retorno FALSE.
     * Caso contrário segue o fluxo e retorna um 
     * array[0]
     */
    try{
      $usuarios = $this->DB->consultar('usuarios', '*', "`id`='".$id."'");
    }catch(\Exception $e){
      $error = $e->getMessage() . 
      ' do arquivo '. $e->getFile() . 
      ' na linha ' . $e->getLine() .
      ' erro capturado no arquivo ' . __FILE__ . 
      ' da linha ' . __LINE__ . '';
      $ErrorLog = new ErrorLog;
      $ErrorLog->writeLog($error);       
      return FALSE;
    }
    return $usuarios;

  }

  public function create($data){
    
    if( !empty($data) ):
            
      $GenerateUniqID = new GenerateUniqID;
      $user['id'] = ( empty($data['id']) ) ? $GenerateUniqID->getId() : $data['id']; 
      $user['usuario'] = strip_tags($data['usuario']);
      // Hash the password:
      $user['senha'] = strip_tags( DataHash::hash($data['senha']) );
      $user['email'] = strip_tags($data['email']);
              
      //Validação dos dados
      $DataValidator = new DataValidator;
      $DataValidator->set('Usuário', $user['usuario'])
      ->is_required()
      ->min_length(3)
      ->set('Senha', $user['senha'])
      ->is_required()
      ->min_length(8)
      ->set('Email', $user['email'])
      ->is_email();
            
      if( $DataValidator->validate() ):
        
        try {
          $lastId = $this->DB->insert('usuarios', $user);
          //echo "<pre>"; var_dump($lastId); echo "</pre>";die;
        } catch (\Exception $e) {
          $error = $e->getMessage() . 
          ' do arquivo '. $e->getFile() . 
          ' na linha ' . $e->getLine() .
          ' erro capturado no arquivo ' . __FILE__ . 
          ' da linha ' . __LINE__ . '';
          $ErrorLog = new ErrorLog;
          $ErrorLog->writeLog($error);
          return FALSE;
        }

      else:
        throw new \Exception('[Error]: Dados inválidos' . 
          "\n" . 
          $DataValidator->get_errors());
      endif;
      
      $usuario = $this->DB->consultar('usuarios','`usuario`,`email`,`data_cadastro`','`id`='.$lastId.'');
            
      return $usuario;

    endif;
    
  }

  public function edit($id){
    
    $userExist = $this->DB->consultar('usuarios', '`id`', "`id`='".$id."'" );
    
  }

  public function delete($id){

    if( $this->DB->delete('usuarios', "id='".$id."'") ):

      $msg = [
        'title' => 'Usuário deletado com sucesso!',
        'msg'   => 'Usuário ID: ' .$id. ' Deletado com sucesso.',
        'class' => 'alert alert-success',
      ];

      return $msg;

    endif;

    return FALSE;
    
  }

  public function showUser($id){
    
    try {
      $usuario = $this->DB->consultar('usuarios', '*', "`id`='".$id."'" );
      //echo "<pre>"; var_dump($lastId); echo "</pre>";die;
    } catch (\Exception $e) {
      $error = $e->getMessage() . 
      ' do arquivo '. $e->getFile() . 
      ' na linha ' . $e->getLine() .
      ' erro capturado no arquivo ' . __FILE__ . 
      ' da linha ' . __LINE__ . '';
      $ErrorLog = new ErrorLog;
      $ErrorLog->writeLog($error);
      return FALSE;
    }

    return $usuario;
    
  }

}