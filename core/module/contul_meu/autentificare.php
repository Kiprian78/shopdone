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
if(h($_POST['parola']) !== "" && h($_POST['email']) !== "" )
{

  $sql = "SELECT * FROM clienti WHERE cont_activ >= 1 AND email = '".h($_POST['email'])."' AND parola = md5('".h($_POST['parola'])."') LIMIT 1;";
  $cliLogin = @getRec($sql);
  
  if($cliLogin['id_client'] < 1 )
  {	 
    $info = "Datele introduse sunt invalide!<br>Email: ".h($_POST['email'])."<br>Parola: ".h($_POST['parola']);
    $aip = h($_SERVER['REMOTE_ADDR']);
    $user_info = h($_SERVER['HTTP_USER_AGENT']);

    $sql= "INSERT INTO clienti_logs SET ";
    $sql.= "data_ora = NOW(), ";
    $sql.= "status = 'Error' ,";
    $sql.= "id_client  = '0' ,";
    $sql.= "info = '".$info."' ,";
    $sql.= "aip = '".$aip."' ,";
    $sql.= "user_info = '".$user_info."';";
    @mysqli_query($con,$sql);

    $showPost = 1; 
    $msgPost.= '<h3 class="text-danger">Datele de AUTENTIFICARE sunt invalide!</h3>';
    $msgPost.= '<p><strong>Verificati daca datele introduse sunt corecte!</strong><br>Puteti recupera datele contului accesand sectiunea de <a href="recovery/"><strong>RECUPERARE</strong></a> cont.</p>';
    $msgPost.= '<script> const Go2Register = function(){ window.location.href="login/"; }  setTimeout(Go2Register,6000); </script>'."\n";
  } 
  else 
  {

    $_SESSION['CLIENT_ID'] = $cliLogin['id_client'];
    $_SESSION['CLIENT_NAME'] = $cliLogin['clientul'];

    $info = "Clientul ".h($cliLogin['id_client'])." s-a autentificat/conectat cu success in magazin !";
    $aip = h($_SERVER['REMOTE_ADDR']);
    $user_info = h($_SERVER['HTTP_USER_AGENT']);

    $sql= "INSERT INTO clienti_logs SET ";
    $sql.= "data_ora = NOW(), ";
    $sql.= "status = 'Login' ,";
    $sql.= "id_client  = '0' ,";
    $sql.= "info = '".$info."' ,";
    $sql.= "aip = '".$aip."' ,";
    $sql.= "user_info = '".$user_info."';";
    @mysqli_query($con,$sql);

    @goRedirect('contul-meu/'); die();
    
  }
}
/*****************************************************************************/
$incTPL = 'contul_meu/autentificare.tpl';
$pag->assign('showPost',$showPost);
$pag->assign('msgPost',$msgPost);
/*****************************************************************************/
