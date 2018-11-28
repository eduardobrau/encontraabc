<?php

namespace core;

class Uri{

  private $uri;
  private $controller;
  private $action;
  private $params;
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
    $this->getUri();
    $this->iniProps();
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
  private function getUri(){
    return $this->uri = parse_url($_SERVER['REQUEST_URI']);
  }

  private function retPath(){

    if(!empty($this->uri['path'])):
      
      //echo "<pre>"; print_r($this->uri); echo "</pre>";
      
      /***
       * Retorna parte do path, seguindo a expressão regular
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
       */     
      if( preg_match($pattern, $this->uri['path'], $matches) ):
        $path = explode('/',$matches[0]);        
        return $path;
      endif;

      $pattern = '/(\w+-?\w+)/'; 

      if( preg_match($pattern, $this->uri['path'], $matches) ):
        $path = explode('/',$matches[0]);
        return $path;
      endif;   

    endif;
    
  }

  private function iniProps(){
    
    $path = $this->retPath();
    //echo "<pre>"; print_r($path); echo "</pre>";   
    $this->action = ( is_array($path) and (count($path) >= 2) ) ? strtolower($path[1]) : 'index';
    $this->controller = ucfirst(strtolower($path[0]));
    
  }

  public function retController(){
    return $this->controller;
  }

  public function retAction(){
    return $this->action;
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
  public function getParams(){       
    if( !empty($this->uri['query']) ):
      parse_str($this->uri['query'], $this->params);
      return $this->params;
    endif;
  }

  public function isHome(){
    return ( !empty($this->uri) and $this->uri['path'] === '/' ) ? true : false;
  }


}