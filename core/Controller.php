<?php

namespace core;
use core\Uri;

class Controller{

  private static $controller;
  private static $action;
  private static $uri;

  /**
   * Instancia um objeto do tipo Uri e apartir deste método
   * é possível chamar outros métodos dentro ou fora do escopo
   * da classe Controller pertecente a classe Uri
   * esta técnica é conhecida como composição, onde uma classe
   * é formada por uma ou mais classes externas para formar
   * um objeto mais complexo.
   */
  public static function Uri(){
    return self::$uri = Uri::getInstance();
  }
  
  public static function getController(){
    self::$controller = self::Uri()::retController();
    return self::$controller;
  }

  public static function getAction(){
    return self::$action = self::Uri()::retAction();
  }


}

