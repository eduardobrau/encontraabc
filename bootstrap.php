<?php

ini_set("display_errors", 'On');
error_reporting(E_ALL);

session_start();

// Configurações de conexão
define('CONFIG', [
  'host' => 'mysql',
  'database' => 'meuprojeto',
  'user' => 'root',
  'pass' => 'test',
]);

require('vendor/autoload.php');
