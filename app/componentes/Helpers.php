<?php

namespace app\componentes;


class Helpers{

  public static function getController($uri){
    /**
    * Retorna parte de uma string /usuarios/index
    * usuarios/index
    */ 
    $uri = substr($uri,1);
    $datas = explode('/', $uri);
    $controller['controller'] = $datas[0];    
    $controller['action'] = $datas[1];
    
    return $controller;
   
  }

}