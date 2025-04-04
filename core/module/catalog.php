<?php
/***************************************************************/
$incTPL = 'catalog.tpl';
/***************************************************************/
$params = explode('-',h($xRoutes[1]));
$categID = (int) $params[0];
$xCateg = @getRec("SELECT * FROM categorii WHERE activ >= 1 AND id_cat = '".$categID."' LIMIT 1");
if($xCateg['id_cat'] < 1){ @goRedirect('./'); die(); }
/***************************************************************/
$pag->SEO($xCateg['seo_page_title'],$xCateg['seo_meta_keys'],$xCateg['seo_meta_desc']);
/***************************************************************/
$bc = new Breadcrumb($xCateg['categoria']);
$catalog_url = 'catalog/'.$xCateg['id_cat'].'-'.Text2URL(trim($xCateg['categoria'])).'.html';
/***************************************************************/
if($xCateg['id_root_cat'] >= 1){
$xRootCateg = @getRec("SELECT * FROM categorii WHERE activ >= 1 AND id_cat = '".$xCateg['id_root_cat']."' LIMIT 1");
$cat_link_url = 'catalog/'.$xRootCateg['id_cat'].'-'.Text2URL(trim($xRootCateg['categoria'])).'.html';
$bc->addItem($xRootCateg['categoria'],$cat_link_url); }
/***************************************************************/
$bc->addItem($xCateg['categoria']);
$bc->getHTML();
/***************************************************************/
/** SORTAREA LISTARII PRODUSELOR */
/***************************************************************/
$sqlOrderSort = ""; $sqlConditieSuplim = "";
/***************************************************************/
switch(h($_GET['sortBy'])){

  default: $sqlOrderSort = "produsul ASC"; break;
  case 'name_asc': $sqlOrderSort = "produsul ASC"; $sqlConditieSuplim = ""; break;
  case 'name_desc': $sqlOrderSort = "produsul DESC"; $sqlConditieSuplim = ""; break;
  case 'pret_asc': $sqlOrderSort = "pret_final ASC"; $sqlConditieSuplim = ""; break;
  case 'pret_desc': $sqlOrderSort = "pret_final DESC"; $sqlConditieSuplim = ""; break;
  case 'noi_asc': $sqlOrderSort = "data_add ASC"; $sqlConditieSuplim = ""; break;
  case 'promo_asc': $sqlOrderSort = "discount DESC"; $sqlConditieSuplim = ""; break;
}
/***************************************************************/
$LISTA_PRODUSE = ''; // variabila RECIPIENT pentru listare/bindarea produselor si afisare lor in HTML
/***************************************************************/
$sql = "SELECT * FROM produse WHERE activ >= 1 AND '".$xCateg['id_cat']."' IN (id_cat_1,id_cat_2,id_cat_3) ";
$sql.= $sqlConditieSuplim." ORDER BY ".$sqlOrderSort;
/***************************************************************/
/* $LISTA_PRODUSE.= '<pre>'.$sql.'</pre>'; // DEBUG SQL rezultat/construit */
/***************************************************************/
$result = @mysqli_query($con,$sql); // interogarea customizata functie de SORTARE selectata
$totals = @mysqli_num_rows($result); // rezultate REGASITE din Interogare din DB
/***************************************************************/
if($totals < 1){
  $LISTA_PRODUSE.= '<div class="col-12 text-center border rounded bg-light">
  <h6 class="mt-90 mb-90">Nu am gasit rezultate</h6>
  </div>'."\n\n"; 
}
/***************************************************************/
while($row = @mysqli_fetch_assoc($result))
{
  $produs = new ProdusCard($row['id_produs']);
  $LISTA_PRODUSE.= $produs->getHTML();
}
@mysqli_free_result($result);
/***************************************************************/
$pag->assign('TOTALS',$totals); // Bindare TOTAL REZULTATE
$pag->assign('LISTA_PRODUSE',$LISTA_PRODUSE); // Bindarea PRODUSELOR 
/***************************************************************/
$sortBy = array(); // Colectia pentru Bindare campului de selectie la SORTARE rezultatelor
/***************************************************************/
$sortBy[] = array('label'=>"Denumirea A - Z",'link_url'=>$catalog_url.'?sortBy=name_asc',
                   'selected'=>(h($_GET['sortBy']) == "name_asc" || empty(h($_GET['sortBy'])) ? 'selected' : ''));

$sortBy[] = array('label'=>"Denumirea Z - A",'link_url'=>$catalog_url.'?sortBy=name_desc',
                   'selected'=>(h($_GET['sortBy']) == "name_desc" ? 'selected' : ''));

$sortBy[] = array('label'=>"Preturi Mic - Mare",'link_url'=>$catalog_url.'?sortBy=pret_asc',
                   'selected'=>(h($_GET['sortBy']) == "pret_asc" ? 'selected' : ''));

$sortBy[] = array('label'=>"Preturi Mare - Mic",'link_url'=>$catalog_url.'?sortBy=pret_desc',
                   'selected'=>(h($_GET['sortBy']) == "pret_desc" ? 'selected' : ''));

$sortBy[] = array('label'=>"Cele mai noi primele",'link_url'=>$catalog_url.'?sortBy=noi_asc',
                   'selected'=>(h($_GET['sortBy']) == "noi_asc" ? 'selected' : ''));

$sortBy[] = array('label'=>"Promotiile primele",'link_url'=>$catalog_url.'?sortBy=promo_asc',
                   'selected'=>(h($_GET['sortBy']) == "promo_asc" ? 'selected' : ''));                   
/***************************************************************/
$pag->assign('sortBy',$sortBy); // Bindare Selectie la SORTARE rezultatelor
/***************************************************************/