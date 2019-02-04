<?php
namespace app\componentes;
// Create a password class to handle management of this:
// https://www.ibm.com/developerworks/br/library/wa-php-renewed_2/index.html
class DataHash {

  /*Gera o hash com o algoritmo mais sofisticado
  do que os tradicionais md5 e sha1 já ultrapassados
  usando o algoritmo sha512 concatenando sempre com
  o mesmo Salt*/
  public static function hash($password) {
    return password_hash($password, PASSWORD_BCRYPT);
  }

  public static function verify($password, $hash) {
    return (password_verify($password,$hash));
  }

}
