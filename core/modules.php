<?php
/**********************************************************************/
/** verificam daca CLIENTUL este LOGAT in Magazin */
if($_SESSION['CLIENT_ID'] >= 1 && $_SESSION['CLIENT_NAME'] !== "")
{
  define('UID',h($_SESSION['CLIENT_ID']));
} 
else 
{
  define('UID',session_id());
}
/**********************************************************************/	 
/** DACA este logat sau fara cont se DEFINESTE CONSTANTA ... UID */
$CosulMeu = @getRec("SELECT COUNT(*) as x FROM rezervari_cos WHERE uid = '".trim(UID)."' LIMIT 1;");
/**********************************************************************/
include_once('rutine_ajax.php'); // Apelarile AJAX cu JQUERY
/**********************************************************************/
$route = h($xRoutes[0]);   $subroute = h($xRoutes[1]);
/**********************************************************************/
$pag = new WebPage();      $incTPL = 'index.tpl';
/**********************************************************************/
$ShowAC = (int) $_COOKIE['AgreeCookies'] == "Yes" ? 0 : 1;
$pag->assign("ShowAgreeCookies",$ShowAC);
/**********************************************************************/
switch($route)
{
  case 'inregistrare': include_once(INC_MODULE."contul_meu/inregistrare.php"); break;
  case 'login': include_once(INC_MODULE."contul_meu/autentificare.php"); break;
  case 'recovery': include_once(INC_MODULE."contul_meu/recovery.php"); break;
  case 'contul-meu':

    $ClientID = 0;$ClientName = "";
    if($_SESSION['CLIENT_ID'] >= 1 && h($_SESSION['CLIENT_NAME']) !== '')
    {
      /** Se verifica aici daca exista si se preiau DATELE CLIENTULUI din BD functie de ID CLIENT din sesiune */
      $xClient = @getRec("SELECT * FROM clienti WHERE id_client = '".$_SESSION['CLIENT_ID']."' AND cont_activ >= 1 LIMIT 1;");
      $_SESSION['CLIENT_ID'] = $xClient['id_client'];
      $_SESSION['CLIENT_NAME'] = $xClient['clientul'];  
      
      $pag->assign('CLIENT_ID',$xClient['id_client']);  // Binding variabila ID CLIENT pentru partea VIEW
      $pag->assign('CLIENT_NAME',$xClient['clientul']);  // Binding variabila NUME CLIENT pentru partea VIEW

      switch($subroute)
      {
        default: include_once(INC_MODULE."contul_meu/detalii_client.php"); break;
        case 'informatii': include_once(INC_MODULE."contul_meu/informatii_client.php"); break;
        case 'comenzi': include_once(INC_MODULE."contul_meu/comenzi_client.php"); break;
        case 'favorite': include_once(INC_MODULE."contul_meu/favorite_client.php"); break;
        case 'securitate': include_once(INC_MODULE."contul_meu/securitate_client.php"); break;
        case 'logout': // se distruge SESIUNEA PENTRU CLIENT
          $_SESSION['CLIENT_ID'] = 0; 
          $_SESSION['CLIENT_NAME'] = ""; 
          @goRedirect(''); // redirectare catre LOGIN
          die(); break;
      }
    } else {
      @goRedirect('login/'); die(); // redirectionare catre partea de LOGIN CLIENT
    }
    break;

  case 'produs': include_once(INC_MODULE."detalii_produs.php"); break;
  case 'catalog': include_once(INC_MODULE."catalog.php"); break;
  case 'cosul-meu': include_once(INC_MODULE."cosul_meu.php"); break;
  case 'trimite-comanda': include_once(INC_MODULE."trimite_comanda.php"); break;
  case 'despre':
    switch($subroute)
    { 
     default: include_once(INC_MODULE."povestea_moa.php"); break;
     case 'livrare': include_once(INC_MODULE."despre_livrare.php"); break;
     case 'comenzi': include_once(INC_MODULE."despre_comenzi.php"); break;
     case 'povestea': include_once(INC_MODULE."povestea_moa.php"); break;
     case 'atelier': include_once(INC_MODULE."despre_atelier.php"); break;
     case 'servicii': include_once(INC_MODULE."oferta_servicii.php"); break;
    }
  break;
  case 'galerie-media': include_once(INC_MODULE."galerie_media.php"); break;      
  case 'faq': include_once(INC_MODULE."faq.php"); break;
  case 'testimoniale': include_once(INC_MODULE."testimoniale.php"); break;
  case 'noutati': include_once(INC_MODULE."noutati.php"); break;
  case 'blog': include_once(INC_MODULE."blog.php"); break;
  case 'contact': include_once(INC_MODULE."contact.php"); break;
  case 'politica-cookies': include_once(INC_MODULE."politica_cookies.php");  break;
  case 'politica-gdpr': include_once(INC_MODULE."politica_datelor_gdpr.php");  break;
  case 'termeni-conditii': include_once(INC_MODULE."termeni_conditii.php");  break;
  case 'abonare': include_once(INC_MODULE."abonare_newsletter.php");  break;
  case 'cautare': include_once(INC_MODULE."cautare.php");  break;
  case 'promotii': include_once(INC_MODULE."promotii.php"); break;
  case 'toate-produsele': include_once(INC_MODULE."toate_produsele.php"); break;

  default:   
  include_once(INC_MODULE."startup.php");
  break;
}
/**********************************************************************/ 
$ClientID = 0;$ClientName = "";
if($_SESSION['CLIENT_ID'] >= 1 && h($_SESSION['CLIENT_NAME']) !== '')
{
  /** Se verifica aici daca exista si se preiau DATELE CLIENTULUI din BD functie de ID CLIENT din sesiune */
  $xClient = @getRec("SELECT * FROM clienti WHERE id_client = '".$_SESSION['CLIENT_ID']."' AND cont_activ >= 1 LIMIT 1;");
  $_SESSION['CLIENT_ID'] = $xClient['id_client'];
  $_SESSION['CLIENT_NAME'] = $xClient['clientul'];  
  
  $pag->assign('CLIENT_ID',$xClient['id_client']);  // Binding variabila ID CLIENT pentru partea VIEW
  $pag->assign('CLIENT_NAME',$xClient['clientul']);  // Binding variabila NUME CLIENT pentru partea VIEW
}
/**********************************************************************/ 
$TotalCosulMeu = (int) $CosulMeu['x'];
$pag->assign('TotalCosulMeu',$TotalCosulMeu);
/**********************************************************************/
$pag->display($incTPL);
/**********************************************************************/