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

//echo "<pre>"; var_dump(Controller::getController()); echo "</pre>";die;

if( Controller::Uri()::isHome() ):
  //echo "<pre>"; var_dump(Uri::isHome()); echo "</pre>";
  $view = new View;
  $view->load('home');
else:
  $params = ( !empty(Controller::Uri()::getParams()) ) ? Controller::Uri()::getParams() : NULL;
  $nameSpace = "app\\controllers\\" . Controller::getController();
  
  if( class_exists($nameSpace) ):
    try{
      new $nameSpace(Controller::getAction(),$params);
    }catch(\Exception $e){
      $view = new View;
      $view->load('erro/error', $e->getMessage());
    }
  endif;

endif;