<?php
/*****************************************************************************/
$params = explode('-',h($xRoutes[1]));
$newsID = (int) $params[0];
if($newsID >= 1){
/*****************************************************************************/
$xNoutate = @getRec("SELECT * FROM noutati WHERE activ >= 1 AND id_news = '".$newsID."' LIMIT 1;");
if($xNoutate['id_news'] < 1){ @goRedirect('noutati/'); die(); }
/*****************************************************************************/
@mysqli_query($con,"UPDATE noutati SET accesari=accesari+1 WHERE activ >= 1 AND id_news = '".$newsID."' LIMIT 1;");
$incTPL = 'detalii_noutate.tpl';
$pag->SEO($xNoutate['art_title'],$xNoutate['seo_meta_keys'],$xNoutate['seo_meta_desc']);
/*****************************************************************************/
$bc = new Breadcrumb('Detalii Blog');
$bc->addItem('Noutati','noutati/');
$news_link_url = 'noutati/'.$xNoutate['id_news'].'-'.Text2URL(substr(trim($xNoutate['art_title']),0,65)).'.html';
$bc->addItem(trim($xNoutate['art_title']),$news_link_url);
$bc->getHTML();
/*****************************************************************************/

if(file_exists($xNoutate['vpath'].$xNoutate['file_name']) && $xNoutate['file_name'] !== ''){
  $xNoutate['imaginea'] = $xNoutate['vpath'].$xNoutate['file_name'];
} else { 
  $xNoutate['imaginea'] = 'assets/images/fara-categorie.jpg'; 
}
$xNoutate['data_pub'] = xDateTime($xNoutate['date_pub']);
$pag->assign('xNoutate',$xNoutate);
/*****************************************************************************/
$alteNews = array(); 
$sql = "SELECT * FROM noutati WHERE activ >= 1 AND id_news <> '".$xNoutate['id_news']."' ORDER BY date_pub DESC LIMIT 0,8";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux); $k = 0;
while($row = @mysqli_fetch_assoc($rezux)) 
{
  $alteNews[$k] = $row;
  $alteNews[$k]['link_url'] = 'noutati/'.$row['id_news'].'-'.Text2URL(substr(trim($row['art_title']),0,65)).'.html';
  $alteNews[$k]['date_pub'] = xDate($row['date_pub']);
  $info = strip_tags($row['art_info']);
  $alteNews[$k]['info'] = substr($info,0,123)."...";
  $alteNews[$k]['read_more'] = "Citeste mai mult";

  if(file_exists($row['vpath'].$row['file_name']) && $row['file_name'] !== ''){
    $alteNews[$k]['imaginea'] = $row['vpath'].$row['file_name'];
  } else { 
    $alteNews[$k]['imaginea'] = 'assets/images/fara-categorie.jpg'; 
  }

  $k++;
} @mysqli_free_result($rezux);
$pag->assign('showAlteNoutati',$k);
$pag->assign('alteNews',$alteNews);




/*****************************************************************************/
} else {
/*****************************************************************************/
$incTPL = 'lista_noutati.tpl';
$selTM = $pag->getTM(9);
/*****************************************************************************/
$bc = new Breadcrumb('Noutati');
$bc->addItem('Noutati');
$bc->getHTML();
/*****************************************************************************/
$lstNews = array(); $k = 0;
$sql = "SELECT * FROM noutati WHERE activ >= 1 ORDER BY date_pub DESC";
$result = @mysqli_query($con, $sql);
/*****************************************************************************/
while ($row = mysqli_fetch_assoc($result)) 
{
  $lstNews[$k] = $row;
  $lstNews[$k]['link_url'] = 'noutati/'.$row['id_news'].'-'.Text2URL(substr(trim($row['art_title']),0,65)).'.html';
  $lstNews[$k]['date_pub'] = xDate($row['date_pub']);
  $info = strip_tags($row['art_info']);
  $lstNews[$k]['info'] = substr($info,0,123)."...";
  $lstNews[$k]['read_more'] = "Citeste mai mult";

  if(file_exists($row['vpath'].$row['file_name']) && $row['file_name'] !== ''){
    $lstNews[$k]['imaginea'] = $row['vpath'].$row['file_name'];
  } else { 
    $lstNews[$k]['imaginea'] = 'assets/images/fara-categorie.jpg'; 
  }

  $k++;
}
@mysqli_free_result($result);
/*****************************************************************************/
$pag->assign('showNews',$k);
$pag->assign('lstNews',$lstNews);
/*****************************************************************************/
}