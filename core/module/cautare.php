<?php
/***************************************************************/
$incTPL = 'cautare.tpl';
/***************************************************************/
$selTM = $pag->getTM(28);
$pag->SEO($selTM['seo_page_title'],$selTM['seo_meta_keys'],$selTM['seo_meta_desc']);
/***************************************************************/
$bc = new Breadcrumb("Cauta: ".h($_GET['caut']));
$catalog_url = 'cautare/?caut='.h($_GET['caut']);
/***************************************************************/
$bc->addItem("Rezultate: ".h($_GET['caut']));
$bc->getHTML();
/***************************************************************/
/** SORTAREA LISTARII TUTUROR PRODUSELOR REGASITE LA CAUTARE */
/***************************************************************/
$sqlOrderSort = "";
/***************************************************************/
switch(h($_GET['sortBy'])){

  default: $sqlOrderSort = "produsul ASC"; break;
  case 'name_asc': $sqlOrderSort = "produsul ASC"; break;
  case 'name_desc': $sqlOrderSort = "produsul DESC"; break;
  case 'pret_asc': $sqlOrderSort = "pret_final ASC"; break;
  case 'pret_desc': $sqlOrderSort = "pret_final DESC"; break;
  case 'noi_asc': $sqlOrderSort = "data_add ASC"; break;
  case 'promo_asc': $sqlOrderSort = "discount DESC"; break;
}
/***************************************************************/
$LISTA_PRODUSE = ''; // variabila RECIPIENT pentru listare/bindarea produselor si afisare lor in HTML
$xS = " LIKE '%".h($_GET['caut'])."%' "; // parametru cautare
/***************************************************************/
$sql = "SELECT * FROM produse WHERE activ >= 1 AND (produsul $xS OR info $xS OR seo_meta_keys $xS OR seo_meta_desc $xS) ";
$sql.= "ORDER BY ".$sqlOrderSort;
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
$sortBy[] = array('label'=>"Denumirea A - Z",'link_url'=>$catalog_url.'&sortBy=name_asc',
                   'selected'=>(h($_GET['sortBy']) == "name_asc" || empty(h($_GET['sortBy'])) ? 'selected' : ''));

$sortBy[] = array('label'=>"Denumirea Z - A",'link_url'=>$catalog_url.'&sortBy=name_desc',
                   'selected'=>(h($_GET['sortBy']) == "name_desc" ? 'selected' : ''));

$sortBy[] = array('label'=>"Preturi Mic - Mare",'link_url'=>$catalog_url.'&sortBy=pret_asc',
                   'selected'=>(h($_GET['sortBy']) == "pret_asc" ? 'selected' : ''));

$sortBy[] = array('label'=>"Preturi Mare - Mic",'link_url'=>$catalog_url.'&sortBy=pret_desc',
                   'selected'=>(h($_GET['sortBy']) == "pret_desc" ? 'selected' : ''));

$sortBy[] = array('label'=>"Cele mai noi primele",'link_url'=>$catalog_url.'&sortBy=noi_asc',
                   'selected'=>(h($_GET['sortBy']) == "noi_asc" ? 'selected' : ''));

$sortBy[] = array('label'=>"Promotiile primele",'link_url'=>$catalog_url.'&sortBy=promo_asc',
                   'selected'=>(h($_GET['sortBy']) == "promo_asc" ? 'selected' : ''));                   
/***************************************************************/
$pag->assign('sortBy',$sortBy); // Bindare Selectie la SORTARE rezultatelor
/***************************************************************/