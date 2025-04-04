<?php
/*****************************************************************************/
function con()
{ 
  global $con; 
  $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

  if(!$con)
  { 
    die("Eroare de conectare la MYSQL: ".mysqli_connect_error()); 
  } 
  return $con; 
}
/*****************************************************************************/
function discon()
{ 
  global $con; 
  @mysqli_close($con); 
}
/*****************************************************************************/
function getRec($sql = '')
{ 
  global $con; 
  $rez = @mysqli_query($con,$sql); 
  $totals = @mysqli_num_rows($rez);
  $rezults = ($totals >= 1 ? @mysqli_fetch_assoc($rez) : NULL);  
  @mysqli_free_result($rez); 
  return $rezults; 
}
/*****************************************************************************/ 
 function getArr($sql = '',$rezultate = "") { 
  global $con; 
  if(!is_array($rezultate)) { 
    $rezultate = array(); 
  }
  $rez = @mysqli_query($con, $sql); 
  while($r = @mysqli_fetch_row($rez)) { 
    $rezultate[$r[0]] = $r[1]; 
  }
  @mysqli_free_result($rez); 
  return (array) $rezultate; 
}
/*****************************************************************************/ 
function GetPagina($idTM=0)
{
  global $con,$SEO; 
  $xSectiune = array();
  $xSectiune = @getRec("SELECT * FROM top_meniu WHERE id_tm = '".$idTM."' LIMIT 1;");

  /** PRELUARE/SETARE INFORMATII in Obiectul SEO 
   * per fiecare PAGINA ACCESATA si afisate in begin.php [core/pagini/sectiuni/begin.php] */

  if( trim($xSectiune['seo_page_title']) !== '') 
  {
    $SEO->setPageTitle($xSectiune['seo_page_title']); // definire SEO TITLUL PAGINA
    $SEO->setMetaKeys($xSectiune['seo_meta_keys']); // definire SEO META KEYWORDS
    $SEO->setMetaDesc($xSectiune['seo_meta_desc']); // definire SEO META DESCRIPTION
  }
  /** RETURNARE ARRAY cu informatii PAGINA X = ID TOP MENIU */
  return (array)$xSectiune;
}
/*****************************************************************************/ 
function GetConfiguratie()
{
  global $con; 
  $wsConfig = array();
  $rezults = @mysqli_query($con,"SELECT * FROM x_configuratie ORDER BY grupa ASC, keya ASC");
  while($row = @mysqli_fetch_assoc($rezults))
  {
    switch($row['tip'])
    {
      case 'TA': 
      $wsConfig[$row['keya']] = nl2br($row['value_']); 
      break;

      default: 
      $wsConfig[$row['keya']] = trim($row['value_']); 
      break;

    }    
  }
  @mysqli_free_result($rezults);
  return (array)$wsConfig;
}
/*****************************************************************************/ 
function GetSocialMedia()
{
  global $con; 
  $wsSMedia = array(); $smFooter = ''; $smToolbar = '';
  $rezults = @mysqli_query($con,"SELECT * FROM social_media WHERE activ >= 1 ORDER BY nivel ASC");
  while($row = @mysqli_fetch_assoc($rezults))
  {
    $smFooter.= '<a class="btn btn-outline-light btn-social me-3" href="'.$row['link_url'].'" target="_blank" title="'.$row['canal'].'">';
    $smFooter.= '<i class="'.$row['icoana'].'"></i></a>'."\n";   

    $smToolbar.= '<a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="'.$row['link_url'].'" ';
    $smToolbar.= 'target="_blank" title="'.$row['canal'].'"><i class="'.$row['icoana'].' fw-normal"></i></a>'."\n";
  }
  @mysqli_free_result($rezults);
  $wsSMedia['footer'] = $smFooter;
  $wsSMedia['toolbar'] = $smToolbar;
  return (array)$wsSMedia;
}
/*****************************************************************************/ 
function GetFooterPhotos()
{
  global $con; 
  $wsSMedia = array(); $smFooter = ''; $smToolbar = '';
  $rezults = @mysqli_query($con,"SELECT * FROM social_media WHERE activ >= 1 ORDER BY nivel ASC");
  while($row = @mysqli_fetch_assoc($rezults))
  {
    $smFooter.= '<a class="btn btn-outline-light btn-social me-3" href="'.$row['link_url'].'" target="_blank" title="'.$row['canal'].'">';
    $smFooter.= '<i class="'.$row['icoana'].'"></i></a>'."\n";   

    $smToolbar.= '<a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="'.$row['link_url'].'" ';
    $smToolbar.= 'target="_blank" title="'.$row['canal'].'"><i class="'.$row['icoana'].' fw-normal"></i></a>'."\n";
  }
  @mysqli_free_result($rezults);
  $wsSMedia['footer'] = $smFooter;
  $wsSMedia['toolbar'] = $smToolbar;
  return (array)$wsSMedia;
}
/*****************************************************************************/
function LogUser2DB($status='Login',$auth_info='',$tip_cont='-',$utilizator='')
{
  global $con; $adresa_ip = $_SERVER['REMOTE_ADDR'];
  $sql = "INSERT INTO x_users_logs (status,data_ora,adresa_ip,auth_info,tip_cont,utilizator) VALUES (";
  $sql.= "'".$status."',NOW(),'".$adresa_ip."','".$auth_info."','".$tip_cont."','".$utilizator."');";
  @mysqli_query($con,$sql);
}
/*****************************************************************************/