<?php 

require "../bootstrap.php"; 

use core\View;
use core\Controller;
use app\componentes\Helpers;

/**
 * Retorna a uri da url
 * Array
 * (
 *    [path] => /usuarios/index/
 * )
 *
*/
$Controller = new Controller();
//echo "<pre>"; var_dump($controller->getController()); echo "</pre>";die;

if( $Controller->Uri()->isHome() ):
  //echo "<pre>"; var_dump(Uri::isHome()); echo "</pre>";
  $view = new View;
  $view->load('home');
else:
  $controlador = $Controller->getController();
  $params = ( !empty($Controller->Uri()->getParams()) ) ? $Controller->Uri()->getParams() : NULL;
  $nameSpace = "app\\controllers\\".ucfirst($controlador);
  
  if( class_exists($nameSpace) ):
    try{
      new $nameSpace($Controller->getAction(),$params);
    }catch(\Exception $e){
      $view = new View;
      $view->load('erro/error', $e->getMessage());
    }
  endif;

endif;


/**
 * O arquivo index.php na estrutura atual sempre será solicitado no browser
 * http://localhost/app_php/index.php?module=usuarios&action=index é ele
 * o script responsável por incluir o script bootstrap que primeiramente
 * carrega o arquivo de configuração config.php que é responsável pelas
 * configurações do sistema como variaveis de escopo global usado em todo o
 * sistema, e as funções de autoload encarregada de incluir as classes, componentes,
 * bibliotecas etc... Sem a necessidade de está dando require nos demais arquivos. 
*/