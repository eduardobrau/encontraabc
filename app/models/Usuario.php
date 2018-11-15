<?php

namespace app\models;
use app\componentes\DB;

class Usuario{

  private $DB;

  public function __construct(){
    $this->DB = new DB();
  }

  public function index(){

    // Faz a consulta com LIMIT para exibição dos dados      
    $usuarios = $this->DB->consultar(
      'usuarios', $campos=FALSE, $where=FALSE,
      $like=FALSE, $order='data_cadastro DESC'//,
      //$limit = $inicio .', '. $itens_por_pagina
    );

    return $usuarios;

  }

  public function view($id){

    $usuarios = $this->DB->consultar('usuarios', '*', "`id`='".$id."'");

    return $usuarios;

  }

  public function edit($id){
    
    if( !empty($_POST['USUARIOS']) ):

      $id = strip_tags($_POST['USUARIOS']['id']);
      $user['usuario'] = strip_tags($_POST['USUARIOS']['usuario']);
      $user['senha'] = strip_tags( HashId::hash($_POST['USUARIOS']['senha']) );
      $user['email'] = strip_tags($_POST['USUARIOS']['email']);
            
      //Validação dos dados
      $validador = new DataValidator();
      $validador->set('Usuário', $user['usuario'])
      ->is_required()
      ->min_length(3)
      ->set('Senha', $user['senha'])
      ->is_required()
      ->min_length(8)
      ->set('Email', $user['email'])
      ->is_email();
  
      if( $validador->validate() ):

        $userUpdate = $this->DB->update('usuarios', $user, '`id` = \''.$id.'\'');

        if($userUpdate):
          header("Location: index.php?module=usuarios&action=edit&id=$id");
        endif;

      else:
        $errors = $validador->get_errors();
        /* echo "<pre>";
        print_r($errors);
        echo "</pre>";die; */
      endif;
  
    endif;
      
		// Se usuário existir retorna seu ID
    $usuarios = $this->DB->consultar('usuarios', $campos=NULL, "`id`='".$id."'" );
    
    return $usuarios;
  }

  public function delete($id){

    // Se usuário existir retorna seu ID
    $userExist = $this->DB->consultar('usuarios', '`id`', "`id`='".$id."'" );
    var_dump($userExist);die;
    if( $this->DB->deletar('usuarios', "id='".$id."'") ):
      return $userExist;
    endif;

    

  }

}