<?php
/*****************************************************************************/
$params = explode('-',h($xRoutes[1]));
$blogID = (int) $params[0];
if($blogID >= 1){
/*****************************************************************************/
$xBlog = @getRec("SELECT * FROM blog_articole WHERE activ >= 1 AND id_blog = '".$blogID."' LIMIT 1;");
if($xBlog['id_blog'] < 1){ @goRedirect('noutati/'); die(); }
/*****************************************************************************/
@mysqli_query($con,"UPDATE blog_articole SET accesari=accesari+1 WHERE activ >= 1 AND id_blog = '".$blogID."' LIMIT 1;");
$incTPL = 'detalii_blog.tpl';
$pag->SEO($xBlog['art_title'],$xBlog['seo_meta_keys'],$xBlog['seo_meta_desc']);
/*****************************************************************************/
$bc = new Breadcrumb('Detalii Blog');
$bc->addItem('Blog','blog/');
$blog_link_url = 'blog/'.$xBlog['id_blog'].'-'.Text2URL(substr(trim($xBlog['art_title']),0,65)).'.html';
$bc->addItem(trim($xBlog['art_title']),$blog_link_url);
$bc->getHTML();
/*****************************************************************************/

if(file_exists($xBlog['vpath'].$xBlog['file_name']) && $xBlog['file_name'] !== ''){
  $xBlog['imaginea'] = $xBlog['vpath'].$xBlog['file_name'];
} else { 
  $xBlog['imaginea'] = 'assets/images/fara-categorie.jpg'; 
}
$xBlog['data_pub'] = xDateTime($xBlog['date_pub']);
$pag->assign('xBlog',$xBlog);
/*****************************************************************************/
$alteBlog = array(); 
$sql = "SELECT * FROM blog_articole WHERE activ >= 1 AND id_blog <> '".$xBlog['id_blog']."' ORDER BY date_pub DESC LIMIT 0,8";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux); $k = 0;
while($row = @mysqli_fetch_assoc($rezux)) 
{
  $alteBlog[$k] = $row;
  $alteBlog[$k]['link_url'] = 'noutati/'.$row['id_blog'].'-'.Text2URL(substr(trim($row['art_title']),0,65)).'.html';
  $alteBlog[$k]['date_pub'] = xDate($row['date_pub']);
  $info = strip_tags($row['art_info']);
  $alteBlog[$k]['info'] = substr($info,0,123)."...";
  $alteBlog[$k]['read_more'] = "Citeste mai mult";

  if(file_exists($row['vpath'].$row['file_name']) && $row['file_name'] !== ''){
    $alteBlog[$k]['imaginea'] = $row['vpath'].$row['file_name'];
  } else { 
    $alteBlog[$k]['imaginea'] = 'assets/images/fara-categorie.jpg'; 
  }

  $k++;
} @mysqli_free_result($rezux);
$pag->assign('showAlteBlog',$k);
$pag->assign('alteBlog',$alteBlog);




/*****************************************************************************/
} else {
/*****************************************************************************/
$incTPL = 'lista_blog.tpl';
$selTM = $pag->getTM(9);
/*****************************************************************************/
$bc = new Breadcrumb('Articole din Blog');
$bc->addItem('Blog');
$bc->getHTML();
/*****************************************************************************/
$lstBlog = array(); $k = 0;
$sql = "SELECT * FROM blog_articole WHERE activ >= 1 ORDER BY date_pub DESC";
$result = @mysqli_query($con, $sql);
/*****************************************************************************/
while ($row = mysqli_fetch_assoc($result)) 
{
  $lstBlog[$k] = $row;
  $lstBlog[$k]['link_url'] = 'blog/'.$row['id_blog'].'-'.Text2URL(substr(trim($row['art_title']),0,65)).'.html';
  $lstBlog[$k]['date_pub'] = xDate($row['date_pub']);
  $info = strip_tags($row['art_info']);
  $lstBlog[$k]['info'] = substr($info,0,123)."...";
  $lstBlog[$k]['read_more'] = "Citeste mai mult";

  if(file_exists($row['vpath'].$row['file_name']) && $row['file_name'] !== ''){
    $lstBlog[$k]['imaginea'] = $row['vpath'].$row['file_name'];
  } else { 
    $lstBlog[$k]['imaginea'] = 'assets/images/fara-categorie.jpg'; 
  }

  $k++;
}
@mysqli_free_result($result);
/*****************************************************************************/
$pag->assign('showBlog',$k);
$pag->assign('lstBlog',$lstBlog);
/*****************************************************************************/
}