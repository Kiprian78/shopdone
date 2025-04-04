<?php
/***************************************************************/
$incTPL = 'galerie_media.tpl';
$selTM = $pag->getTM(19);
/***************************************************************/
$bc = new Breadcrumb('Galerie Foto/Video');
$bc->addItem('Galerie Foto/Video');
$bc->getHTML();
/***************************************************************/
$lstFotos = array(); $sql = "SELECT * FROM galerie_foto WHERE activ >= 1 ORDER BY nivel ASC";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux); $k = 0;
while($row = @mysqli_fetch_assoc($rezux)) 
{
  $lstFotos[$k] = $row;
  $lstFotos[$k]['imaginea'] = $row['vpath'].$row['file_name'];
  $k+=1;
} @mysqli_free_result($rezux);
$pag->assign('showFotos',$k);
$pag->assign('lstFotos',$lstFotos);
/***************************************************************/
$lstVideo = array(); $sql = "SELECT * FROM galerie_video WHERE activ >= 1 ORDER BY nivel ASC";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux); $k = 0;
while($row = @mysqli_fetch_assoc($rezux)) 
{
  $lstVideo[$k] = $row;
  $k+=1;
} @mysqli_free_result($rezux);
$pag->assign('showVideo',$k);
$pag->assign('lstVideo',$lstVideo);
/***************************************************************/
