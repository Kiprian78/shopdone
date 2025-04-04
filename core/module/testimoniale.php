<?php
/*****************************************************************************/
$selTM = $pag->getTM(18);
/*****************************************************************************/
$bc = new Breadcrumb($selTM['meniul']);
$bc->addItem($selTM['meniul']);
$bc->getHTML();
/*****************************************************************************/
$lstTest = array(); $k = 0;
$sql = "SELECT * FROM testimoniale WHERE activ >= 1 ORDER BY data_pub DESC";
$rezux = @mysqli_query($con, $sql);
while ($row = @mysqli_fetch_assoc($rezux)) 
{
  $lstTest[$k] = $row;

  $imaginea = 'assets/images/avatar.jpg';
  if(file_exists($row['vpath'].$row['file_name']) && $row['file_name'] !== ''){
  $imaginea = $row['vpath'].$row['file_name']; }
  $lstTest[$k]['imaginea'] = $imaginea;

  $stars = "";
  

  $k+=1;
}
@mysqli_free_result($rezux);
$pag->assign('showTest',$k);
$pag->assign('lstTest',$lstTest);
/*****************************************************************************/
$incTPL = 'testimoniale.tpl';
/*****************************************************************************/
