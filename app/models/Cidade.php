<?php

namespace app\models;

use app\componentes\DB;
use app\componentes\Paginacao;
use app\componentes\DataValidator;
use app\componentes\DataHash;
use app\componentes\ErrorLog;
use app\componentes\GenerateUniqID;
use app\componentes\FormHelpers;

class Cidade{

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
    $cidades = $Paginacao->showDatas(
      'cidades',$campos=FALSE, $where=FALSE,
      $like=FALSE, $order='cidade ASC'
    );
    $Paginacao->totalItens('cidades','id');
    $nav = $Paginacao->renderNav();
    return ['cidades' => $cidades, 'nav' => $nav];

  }

  public function view($id){
    /**
     * Método view() é possível de erro
     * então trato essa possível falha capturando
     * o erro para mais tarde implementar um log,
     * por enquanto apenas retorno FALSE.
     * Caso contrário segue o fluxo e retorna um 
     * array[0] ou array[0][0]
     */
    try{
      $cidades = $this->DB->view('cidades', '*', "WHERE `id`='".$id."'");
    }catch(\Exception $e){
      $erro = $e->getMessage() . " na linha " . $e->getLine() .
      ' da classe DB';       
      return FALSE;
    }
    return $cidades;

  }

  public function create($data){
        
    if( !empty($data) ):
          
      $cidade['id'] = ( empty($data['id']) ) 
      ? GenerateUniqID::uniqueRandomInt($this->DB,'cidades') 
      : FormHelpers::sanitizeInput($data['id']); 
      $cidade['cidade'] = FormHelpers::sanitizeInput($data['cidade']);
      $cidade['slug'] = FormHelpers::sanitizeInput($data['slug']);
      $cidade['tempo_id'] = FormHelpers::sanitizeInput($data['tempo_id']);
      //echo "<pre>"; print_r($cidade['cidade']); echo "</pre>";    
      
      //Validação dos dados
      $DataValidator = new DataValidator;
      $DataValidator->set('Cidade', $cidade['cidade'])->is_required()->min_length(3)
      ->set('id', $cidade['id'])->is_required()->min_length(10)
      ->set('slug', $cidade['slug'])->is_required();
      //echo "<pre>"; var_dump($DataValidator->get_errors()); echo "</pre>";      
      if( $DataValidator->validate() ):
        
        try {
          $lastId = $this->DB->insert('cidades', $cidade);
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
        $error = '[Error]: Dados inválidos - ';
        $erros = $DataValidator->get_errors();
        foreach ($erros['Cidade'] as $value) {
          $erro[] = $value;
        }
        $error .= implode(', ', $erro);
        throw new \Exception($error);
      endif;
      
      
      /**
       * Faz uma consulta ao DataBase e verifica se foi inserido o registro 
       * em caso afirmativo retorna os dados em um array e caso não exista
       * o registro retorna FALSE.
       * */ 
      $cidade = $this->DB->view('cidades','`id`,`cidade`,`tempo_id`,`slug`','WHERE `id`='.$lastId.'');
                  
      return $cidade;

    endif;
    
  }

  public function edit($id){
    
    $cidade = $this->DB->view('cidades', '*', "WHERE `id`='".FormHelpers::sanitizeInput($id)."'");
    
    if( $this->DB->getNumRows() === 1 ){
      return $cidade;
    }
    
    return FALSE;
    
  }

  public function delete($id){

    if( $this->DB->delete('cidades', "id='".$id."'") ):

      $msg = [
        'title' => 'Cidade deletado com sucesso!',
        'msg'   => 'Cidade ID: ' .$id. ' Deletado com sucesso.',
        'class' => 'alert alert-success',
      ];

      return $msg;

    endif;

    return FALSE;
    
  }

  public function showUser($id){
    
    try {
      $cidade = $this->DB->consultar('cidades', '*', "`id`='".$id."'" );
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

    return $cidade;
    
  }

}