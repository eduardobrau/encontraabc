<?php

namespace core;
use app\componentes\Helpers;
//use app\core\Uri;

class Controller{

  private $controller;
  private $action;
  private $uri;

 /*  public static function initialize($uriPath){
    $datas = Helpers::getController($uriPath);
    $this->setController($datas['controller']);
    $this->setAction($datas['action']);
  } */
  /**
   * Instancia um objeto do tipo Uri e apartir deste método
   * é possível chamar outros métodos dentro ou fora do escopo
   * da classe Controller pertecente a classe Uri
   * esta técnica é conhecida como composição, onde uma classe
   * é formada por uma ou mais classes externas para formar
   * um objeto mais complexo.
   */
  public function Uri(){
    return $this->uri = Uri::getInstance();
  }
  
  public function getController(){
    $this->controller = $this->Uri()->retController();
    return $this->controller;
  }

  public function getAction(){
    return $this->action = $this->Uri()->retAction();
  }


}

