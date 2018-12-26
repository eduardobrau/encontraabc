<?php

namespace core;

class Uri{

  private static $uri;
  private static $controller;
  private static $action;
  private static $params;
  private static $instance;

  /**
   * Ao inicializar esta classe já inicia a propriedade $uri
   * pois não faz sentido iniciar este objeto sem ter a variavel
   * super global $_SERVER['REQUEST_URI'] iniciada 
   * alterei a visibilidade do método construtor de public para
   * private dessa maneira essa classe só pode ser instanciada
   * dentro da própria classe, agora que não posso instanciar
   * esse objeto fora do escopo dessa classe, preciso prover
   * um meio de instanciar este objeto por meio de um de seus
   * métodos.
    */
  private function __construct(){
    self::getUri();
    self::iniProps();
  }
  /**
   * Para concretizar um objeto Singleton preciso garantir
   * que só haja uma única instância desse objeto por toda
   * a aplicação e criar uma instância da primeira vez que
   * for chamado e retornar a mesma instância todas as 
   * outras vezes que for chamado. Para ter esse controle
   * preciso criar uma propriedade static $instance que conterá
   *  na memória um objeto Uri. Lembre-se que uma atributo
   * static é um atributo que pertence a Classe e não a um 
   * objeto especifico.
   */
  public static function getInstance(){
    if( empty(self::$instance) ):
      self::$instance = new self;
    endif;
    return self::$instance;
  }

  /**
   * Sempre vai retornar um array com o path e caso tenha parametros
   * retorna esses como uma query string da url digitada
   * exemplo: http://encontraabc.localhost/app/php?id=1232dsd&ul=idfu
   * Array
   * (
   *    [path] => /app/php
   *    [query] => id=1232dsd&ul=idfu
   * )
   * 
  */
  private static function getUri(){
    return self::$uri = parse_url($_SERVER['REQUEST_URI']);
  }

  private static function retPath(){

    if(!empty(self::$uri['path'])):
      
      //echo "<pre>"; print_r(self::$uri); echo "</pre>";
      
      /***
       * Retorna parte do path, seguindo a expressão regular
       * que pode ser interpretada assim, liga qualquer
       * palavra no minimo 1 ou ilimitada vezes podendo 
       * ter um - 1 vez ou seja opcional, seguido de qualquer
       * palavra 1 ou ilimitada vezes sendo obrigatorio ter
       * uma barra / seguido de qualquer palavra etc...
       * exemplo: 
       * http://encontraabc.localhost/usuarios/index/exemplo
       * [path] => /usuarios/index/exemplo
       * retorna somente usuarios/index
       */
      $pattern = '/(\w+-?\w+\/\w+-?\w+)/';
      /**
       * Explode toda ocorrencia de / e para cada
       * ocorrência um novo indice do array
       * (
       *    [0] => usuarios
       *    [1] => index
       * )
       * Caso case com o pattern acima retorna o primeiro
       * indice dessa ocorrência ao método iniProps() na
       * forma de um array, já que foi explodido as /
       */     
      if( preg_match($pattern, self::$uri['path'], $matches) ):
        $path = explode('/',$matches[0]);        
        return $path;
      endif;

      $pattern = '/(\w+-?\w+)/'; 

      if( preg_match($pattern, self::$uri['path'], $matches) ):
        $path = explode('/',$matches[0]);
        return $path;
      endif;   

    endif;
    
  }
  /**
   * iniProps() é responsável por iniciar os valores do controller
   * e da action caso o usuário a digitou se não seta a action
   * como index por padrão.
   */
  private static function iniProps(){
    
    $path = self::retPath();
    //echo "<pre>"; print_r($path); echo "</pre>";   
    self::$action = ( is_array($path) and (count($path) >= 2) ) ? strtolower($path[1]) : 'index';
    self::$controller = ucfirst(strtolower($path[0]));
    
  }

  public static function retController(){
    return self::$controller;
  }

  public static function retAction(){
    return self::$action;
  }

  /**
   * parse_str retorna uma array dos parametros passados
   * via query string da url digitada
   * Array
   *  (
   *   [id] => 1232dsd
   *   [ul] => idfu
   * )
   */
  public static function getParams(){       
    if( !empty(self::$uri['query']) ):
      parse_str(self::$uri['query'], self::$params);
      return self::$params;
    endif;
  }

  public static function isHome(){
    return ( !empty(self::$uri) and self::$uri['path'] === '/' ) ? true : false;
  }

  public static function getUriPath(){
    return self::$uri['path'];
  }

}