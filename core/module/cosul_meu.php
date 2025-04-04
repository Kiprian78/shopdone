<?php
/***************************************************************/
$incTPL = 'cosul_meu.tpl';
$selTM = $pag->getTM(9);
/***************************************************************/
$bc = new Breadcrumb('Coșul Meu');
$bc->addItem('Coșul Meu');
$bc->getHTML();
/***************************************************************/
$subtotal = 0; $total_cos = 0;
/***************************************************************/
$lstCosulMeu = array(); $k = 0;
$sql = "SELECT * FROM rezervari_cos WHERE uid = '".trim(UID)."' ORDER BY data_add ASC";
$result = @mysqli_query($con,$sql);
while ($row = mysqli_fetch_assoc($result)) 
{
  $pretul = $row["pret_unit"];
  $buc = $row["buc"];
  $total = $row["pret_unit"] * $row["buc"];
  $lstCosulMeu[$k] = $row;
  $lstCosulMeu[$k]['nume_produs'] = wordwrap(trim($row['produs']),48,'<br>');  
  $subtotal += $total;

  $k++;
}
@mysqli_free_result($result);
/***************************************************************/
$pag->assign('ShowCos',$k);
$pag->assign('SubTotal',$subtotal+18);
$pag->assign('lstCosulMeu',$lstCosulMeu);
/***************************************************************/



