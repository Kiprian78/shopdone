<?php
class CSRF 
{

  public static function generateToken() 
  {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(30));
  }

  public static function regenToken() 
  {
    $_SESSION['csrf_token'] = NULL;
    $_SESSION['csrf_token'] = bin2hex(random_bytes(30));
  }

  public static function getToken()
  {
    if (!isset($_SESSION['csrf_token'])){
      self::generateToken(); 
    }
    return $_SESSION['csrf_token'];
  }

  public static function verify($token)
  {
    if ($token != self::getToken()) {
      return false;
    }
    return true;
  } 

}
?>
