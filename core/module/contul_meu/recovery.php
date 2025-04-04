<?php
/*****************************************************************************/
$selTM = $pag->getTM(40);
$sselTM = $pag->getTM(42);
/*****************************************************************************/
$bc = new Breadcrumb($selTM['meniul']);
$bc->addItem($selTM['meniul'],$selTM['link_url']);
$bc->addItem($sselTM['meniul'],'login/');
$bc->getHTML();
/*****************************************************************************/
$showPost = 0; $msgPost = "";
/*****************************************************************************/
if(h($_POST['email']) !== "" )
{
  $checkExist = @getRec("SELECT * FROM clienti WHERE email = '".h($_POST['email'])."' LIMIT 1;");
  if($checkExist['id_client'] < 1 )
  {
    $showPost = 1; 
    $msgPost.= '<h3 class="text-danger">Adresa de Email NU exista sau contul dvs este INACTIV !</h3>';
    $msgPost.= '<p>Verificati daca Adresa de E-mail introdusa ... este CORECTA!</p>';
    $msgPost.= '<script> const Go2Register = function(){ window.location.href="login/"; }  setTimeout(Go2Register,6000); </script>'."\n";
  } 
  else 
  {
    $showPost = 1;
    $aip = $_SERVER['REMOTE_ADDR'];
    $parola_clar = @genRandomPass(6);
    $parola = md5($parola_clar);

    $sql= "UPDATE clienti SET ";
    $sql.= "parola = '".mysqli_real_escape_string($con,$parola)."' ,";
    $sql.= "parola_clar = '".mysqli_real_escape_string($con,$parola_clar)."' ,";
    $sql.= "add_edit = NOW() ,";
    $sql.= "adresa_ip = '".$aip."' ";    
    $sql.= "WHERE id_client = '".$checkExist['id_client']."';";    
    @mysqli_query($con,$sql);

    $subiect = "RECUPERARE CONT - MOA.BIJOUX";

    $sablonEmail = @getRec("SELECT * FROM x_sablon_emails WHERE keya = 'email_recovery' LIMIT 1;");
    $mesajul   = trim($sablonEmail['continut']);

    $mesajul   = str_replace('{#SUBIECT#}',$subiect,$mesajul);
    $mesajul   = str_replace('{#DATA_ORA#}',date("d.m.Y H:i"),$mesajul);
    $mesajul   = str_replace('{#NUMELE#}',h($checkExist['clientul']),$mesajul);
    $mesajul   = str_replace('{#EMAIL#}',h($checkExist['email']),$mesajul);
    $mesajul   = str_replace('{#PAROLA#}', $parola_clar ,$mesajul);      
    $mesajul   = str_replace('{#USER_INFO#}',h($_SERVER['HTTP_USER_AGENT']),$mesajul);      
    $mesajul   = str_replace('{#ADRESA_IP#}',h($_SERVER['REMOTE_ADDR']),$mesajul);

    $headers  = "From: ".trim(EMAIL_FROM)."\r\n";
    $headers .= "Reply-To: ".trim(EMAIL_FROM)."\r\n";
    $headers .= "CC: ".trim(EMAIL_OFFICE)."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    @mail(h($_POST['email']),$subiect,$mesajul,$headers);

    $msgPost.= '<h3 class="text-success">Parola pentru CONTUL DVS a fost RESETATA/MODIFICATA si trimisa pe email !</h3>';
    $msgPost.= '<p>Verificati casuta de email pentru a afla NOUA parola!</p>';
    $msgPost.= '<script> const Go2Register = function(){ window.location.href="login/"; }  setTimeout(Go2Register,6000); </script>'."\n";    
    
  }
}
/*****************************************************************************/
$incTPL = 'contul_meu/recovery.tpl';
$pag->assign('showPost',$showPost);
$pag->assign('msgPost',$msgPost);
/*****************************************************************************/
