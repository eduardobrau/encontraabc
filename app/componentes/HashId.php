<?php
// Create a password class to handle management of this:
// https://www.ibm.com/developerworks/br/library/wa-php-renewed_2/index.html
class HashId {

	/*
		Cria um Salt qualquer manual para ser reforçado
		no uso da função hash que vai concatenar o Salt
	*/
  const SALT = 'A2_09)iP_)tu@';
  //private $hash;

  /*Gera o hash com o algoritmo mais sofisticado
  do que os tradicionais md5 e sha1 já ultrapassados
  usando o algoritmo sha512 concatenando sempre com
  o mesmo Salt*/
  public static function hash($password) {
    return hash('md5', self::SALT . $password);
  }

  public static function verify($password, $hash) {
    return ($hash == self::hash($password));
  }

}
 
// Hash the password:
// $hash = HashId::hash('1');
// var_dump($hash);
// Check against an entered password (This example will fail to verify)
// if (HashId::verify('1', $hash)) {
//   echo "Correct Password!\n";
// } else {
//   echo "Incorrect login attempt!\n";
// }