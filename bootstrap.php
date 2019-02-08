<?php

ini_set("display_errors", 'On');
error_reporting(E_ALL);

if( session_status() !== PHP_SESSION_ACTIVE ): 
  session_start();
endif;

// Configurações de conexão
define('CONFIG', [
  'host' => 'mysql',
  'database' => 'meuprojeto',
  'user' => 'root',
  'pass' => 'test',
]);

require('vendor/autoload.php');
