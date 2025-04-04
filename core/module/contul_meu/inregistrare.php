<?php
/*****************************************************************************/
$selTM = $pag->getTM(40);
$sselTM = $pag->getTM(41);
/*****************************************************************************/
$bc = new Breadcrumb($selTM['meniul']);
$bc->addItem($selTM['meniul'],$selTM['link_url']);
$bc->addItem($sselTM['meniul'],'inregistrare/');
$bc->getHTML();
/*****************************************************************************/
$showPost = 0; $msgPost = "";
/*****************************************************************************/
if(h($_POST['numele']) !== "" && h($_POST['email']) !== "" && h($_POST['agree']) >= 1 )
{
  $checkExist = @getRec("SELECT * FROM clienti WHERE clientul = '".h($_POST['numele'])."' AND email = '".h($_POST['email'])."' LIMIT 1;");
  if($checkExist['id_client'] >= 1 )
  {
    $showPost = 1; 
    $msgPost.= '<h3 class="text-danger">Exista deja un utilizator ce foloseste aceasta adresa de e-mail !</h3>';
    $msgPost.= '<p>Recuperati parola pentru contul dvs din sectiunea de Autentificare!</p>';
    $msgPost.= '<script> const Go2Register = function(){ window.location.href="inregistrare/"; }  setTimeout(Go2Register,8000); </script>'."\n";
  } 
  else 
  {
    $showPost = 1;
    $aip = $_SERVER['REMOTE_ADDR'];
    $parola_clar = h($_POST['parola']);
    $parola = md5($parola_clar);

    $sql= "INSERT INTO clienti SET ";
    $sql.= "tip_client = '".mysqli_real_escape_string($con,trim($_POST['tip_client']))."' ,";
    $sql.= "clientul = '".mysqli_real_escape_string($con,trim($_POST['numele']))."' ,";
    $sql.= "adresa_client = '".mysqli_real_escape_string($con,trim($_POST['adresa_client']))."' ,";
    $sql.= "adresa_livrare = '".mysqli_real_escape_string($con,trim($_POST['adresa_livrare']))."' ,";
    $sql.= "adresa_facturare = '".mysqli_real_escape_string($con,trim($_POST['adresa_facturare']))."' ,";
    $sql.= "loc_judet  = '".mysqli_real_escape_string($con,trim($_POST['loc_judet']))."' ,";
    $sql.= "cod_postal = '".mysqli_real_escape_string($con,trim($_POST['cod_postal']))."' ,";
    $sql.= "telefon_1 = '".mysqli_real_escape_string($con,trim($_POST['telefon1']))."' ,";
    $sql.= "telefon_2 = '".mysqli_real_escape_string($con,trim($_POST['telefon2']))."' ,";
    $sql.= "fax = '".mysqli_real_escape_string($con,trim($_POST['fax']))."' ,";
    $sql.= "compania = '".mysqli_real_escape_string($con,trim($_POST['compania']))."' ,";
    $sql.= "cod_fiscal = '".mysqli_real_escape_string($con,trim($_POST['cod_fiscal']))."' ,";
    $sql.= "nr_reg_com = '".mysqli_real_escape_string($con,trim($_POST['nr_reg_com']))."' ,";
    $sql.= "email = '".mysqli_real_escape_string($con,trim($_POST['email']))."' ,";
    $sql.= "parola = '".mysqli_real_escape_string($con,$parola)."' ,";
    $sql.= "parola_clar = '".mysqli_real_escape_string($con,$parola_clar)."' ,";
    $sql.= "data_add = NOW() ,";
    $sql.= "adresa_ip = '".$aip."';";    
    @mysqli_query($con,$sql);

    $client_id = @mysqli_insert_id($con);
    
    if($client_id >= 1)
    {

      $subiect = "CONT NOU CLIENT - MOA.BIJOUX";

      $sablonEmail = @getRec("SELECT * FROM x_sablon_emails WHERE keya = 'email_inregistrare' LIMIT 1;");
      $mesajul   = trim($sablonEmail['continut']);
  
      $mesajul   = str_replace('{#SUBIECT#}',$subiect,$mesajul);
      $mesajul   = str_replace('{#DATA_ORA#}',date("d.m.Y H:i"),$mesajul);
      $mesajul   = str_replace('{#NUMELE#}',h($_POST['numele']),$mesajul);
      $mesajul   = str_replace('{#TIP_CLIENT#}',h($_POST['tip_client']),$mesajul);
      $mesajul   = str_replace('{#EMAIL#}',h($_POST['email']),$mesajul);
      $mesajul   = str_replace('{#PAROLA#}', $parola_clar ,$mesajul);      
      $mesajul   = str_replace('{#ACORDUL#}',(h($_POST['agree'])>=1?'DA':'NU'),$mesajul);
      $mesajul   = str_replace('{#USER_INFO#}',h($_SERVER['HTTP_USER_AGENT']),$mesajul);      
      $mesajul   = str_replace('{#ADRESA_IP#}',h($_SERVER['REMOTE_ADDR']),$mesajul);
  
      $headers  = "From: ".trim(EMAIL_FROM)."\r\n";
      $headers .= "Reply-To: ".trim(EMAIL_FROM)."\r\n";
      $headers .= "CC: ".trim(EMAIL_OFFICE)."\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
  
      @mail(h($_POST['email']),$subiect,$mesajul,$headers);

      $msgPost.= '<h3 class="text-success">Contul dvs a fost creat cu succes !</h3>';
      $msgPost.= '<p>Verificati adresa de e-mail si va asteptam la ma multe comenzi din magazinul online!</p>';
      $msgPost.= '<script> const Go2Register = function(){ window.location.href="inregistrare/"; }  setTimeout(Go2Register,8000); </script>'."\n";
    }
    else
    {
      $msgPost.= '<h3 class="text-danger">Problema cu procesarea formularului de inregistrare!</h3>';
      $msgPost.= '<p>Completati campurile din formular ... cu datele valide ale dvs!</p>';
      $msgPost.= '<script> const Go2Register = function(){ window.location.href="login/"; }  setTimeout(Go2Register,8000); </script>'."\n";    
    }
  }
}
/*****************************************************************************/
$incTPL = 'contul_meu/inregistrare.tpl';
$pag->assign('showPost',$showPost);
$pag->assign('msgPost',$msgPost);
/*****************************************************************************/
