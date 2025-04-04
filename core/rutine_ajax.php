<?php
/**********************************************************************/
/* if(h($_POST['op']) == 'agree-cookies'){
  $_SESSION['agree_cookies'] = md5(time().mt_rand(0,9999999));
  die("COOKIES OK!");
}	*/
/***********************************************************************/
if(h($_POST['do']) == "AbonareNewsletter" && h($_POST['anl_email']) !== "" ) 
{
  $aip = trim($_SERVER['REMOTE_ADDR']);
  $email = h($_POST['anl_email']);

  $sql = "INSERT INTO abonati_newsletter (email,adresa_ip,status) VALUES ('".$email."','".$aip."','ABONAT');";
  @mysqli_query($con, $sql); $newID = @mysqli_insert_id($con);
  @mysqli_query($con, "OPTIMIZE TABLE abonati_newsletter;");

  if($newID >= 1)
  {
    $html.= '<div class="card p-0"><div class="card-header bg-success text-white w-100">';
    $html.= '<strong>Abonare la Newsletter</strong></div>';
    $html.= '<div class="card-body p-3 text-center"><p>Adresa de email: <strong>'.h($_POST['anl_email']).'</strong> '; 
    $html.= ' a fost adăugată la Newsletterul nostru. Va multumim !</p>';
    $html.= '</div></div>';
  } 
  else 
  {
    $html.= '<div class="card p-0"><div class="card-header bg-danger text-white w-100">';
    $html.= '<strong>Abonare la Newsletter</strong></div>';
    $html.= '<div class="card-body p-3 text-center"><p>Adresa de email: <strong>'.h($_POST['anl_email']).'</strong> '; 
    $html.= ' exista deja in Newsletter-ul nostru !</p>';
    $html.= '</div></div>';    
  }
  die($html);

}
/***********************************************************************/
if(h($_POST['do']) == "DeleteDinCos" && h($_POST['cmid']) >= 1 ) 
{
  $cosProdus = @getRec("SELECT * FROM rezervari_cos WHERE id_cart = '".h($_POST['cmid'])."' AND uid = '".trim(UID)."' LIMIT 1;");
  if($cosProdus['id_cart'] >= 1 && $cosProdus['buc'] >= 1)
  {
      @mysqli_query($con,"DELETE FROM rezervari_cos WHERE id_cart = '".h($_POST['cmid'])."' ".
      "AND uid = '".trim(UID)."' LIMIT 1;");
  }
  @mysqli_query($con,"OPTIMIZE TABLE rezervari_cos;");
  die("<p>A fost eliminat produsul X din cos!</p>");
}
/***********************************************************************/
if(h($_POST['do']) == "SetCosPlus" && h($_POST['cmid']) >= 1 ) 
{
  $cosProdus = @getRec("SELECT * FROM rezervari_cos WHERE id_cart = '".h($_POST['cmid'])."' AND uid = '".trim(UID)."' LIMIT 1;");
  if($cosProdus['id_cart'] >= 1 && $cosProdus['buc'] >= 1)
  {
      @mysqli_query($con,"UPDATE rezervari_cos SET buc=buc+1 WHERE id_cart = '".h($_POST['cmid'])."' ".
      " AND uid = '".trim(UID)."' LIMIT 1;");
  }
  @mysqli_query($con,"OPTIMIZE TABLE rezervari_cos;");
  die("<p>Cosul dvs a fost actualizat !</p>");
}
/***********************************************************************/
if(h($_POST['do']) == "SetCosMinus" && h($_POST['cmid']) >= 1 ) 
{
  $cosProdus = @getRec("SELECT * FROM rezervari_cos WHERE id_cart = '".h($_POST['cmid'])."' ".
  "AND uid = '".trim(UID)."' LIMIT 1;");

  if($cosProdus['id_cart'] >= 1 && $cosProdus['buc'] >= 1)
  {
    if($cosProdus['buc'] == 1)
    {
      @mysqli_query($con,"DELETE FROM rezervari_cos WHERE id_cart = '".h($_POST['cmid'])."' ".
      "AND uid = '".trim(UID)."' LIMIT 1;");
    } 
    else 
    {
      @mysqli_query($con,"UPDATE rezervari_cos SET buc=buc-1 WHERE id_cart = '".h($_POST['cmid'])."' ".
      "AND uid = '".trim(UID)."' LIMIT 1;");
    }
  }
  @mysqli_query($con,"OPTIMIZE TABLE rezervari_cos;");
  die("<p>Cosul dvs a fost actualizat !</p>");
}
/***********************************************************************/
if(h($_POST['do']) == "Add2Cos" && h($_POST['pid']) >= 1 ) 
{
  $xProdus = @getRec("SELECT * FROM produse WHERE activ >= 1 AND id_produs = '".h($_POST['pid'])."' LIMIT 1;");

  $link_produs = 'produs/'.$xProdus['id_produs'].'-'.Text2URL(trim($xProdus['produsul'])).'/';
  $imaginea = $xProdus['vpath'].$xProdus['file_name'];
  $divImage = '<a href="cosul-meu/" class="float-start me-3 mb-4"><img src="'.$imaginea.'" height="80" alt="PRODUS" class="rounded" /></a>';
  $html = '';

  $cosProdus = @getRec("SELECT * FROM rezervari_cos WHERE id_produs = '".h($_POST['pid'])."' AND uid = '".trim(UID)."' LIMIT 1;");
  if($cosProdus['id_produs'] == $xProdus['id_produs'] && $xProdus['id_produs'] >= 1)
  {
    $newID = $cosProdus['id_cart'];
    $sql = "UPDATE rezervari_cos SET buc=buc+1 WHERE id_cart='".$newID."' AND uid = '".trim(UID)."' LIMIT 1;";
    @mysqli_query($con, $sql);
  } 
  else 
  {
    $sql = "INSERT INTO rezervari_cos SET ";
    $sql.= "uid = '".trim(UID)."', ";
    $sql.= "produs = '".mysqli_real_escape_string($con,trim($xProdus['produsul']))."', ";
    $sql.= "id_produs = '".$xProdus['id_produs']."', ";
    $sql.= "produs_image = '".mysqli_real_escape_string($con,trim($imaginea))."', ";
    $sql.= "link_url = '".$link_produs."', ";
    $sql.= "pret_unit = '".$xProdus['pret_final']."', ";
    $sql.= "data_add = NOW(), ";
    $sql.= "data_expired = '".date("Y-m-d",strtotime("+2days"))."', ";
    $sql.= "aip = '".h($_SERVER['REMOTE_ADDR'])."', ";
    $sql.= "user_info = '".mysqli_real_escape_string($con,trim($_SERVER['HTTP_USER_AGENT']))."';";
    @mysqli_query($con, $sql);  $newID = @mysqli_insert_id($con);
  }

  @mysqli_query($con,"OPTIMIZE TABLE rezervari_cos;");

  if($newID >= 1)
  {
    $html.= '<div class="card p-0"><div class="card-header bg-success text-white w-100">';
    $html.= '<strong>Adăugare produs în COȘUL MEU</strong></div>';
    $html.= '<div class="card-body pb-1"><p>'.$divImage.'Produsul: <strong>'.h($xProdus['produsul']).'</strong>'; 
    $html.= ' a fost adăugat în <strong>COȘUL MEU</strong>.</p>';
    $html.= '<p><a href="cosul-meu/" class="btn btn-outline-dark w-100">Vezi <strong>COȘUL MEU</strong></a></p></div></div>';
    die($html);
  } 
  else 
  {
    $html.= '<div class="card p-0"><div class="card-header bg-danger text-white w-100">';
    $html.= '<strong>Problemă cu adăugarea în Coșul Meu</strong></div>';
    $html.= '<div class="card-body pb-3"><p>'.$divImage.'Produsul: <strong>'.h($xProdus['produsul']); 
    $html.= ', NU a fost adăugat</strong> în <strong>COȘUL MEU</strong>.</p>';
    $html.= '</div></div>';
    die($html);
  }
}
/***********************************************************************/


