<?php
/***************************************************************/
$incTPL = 'detalii_produs.tpl';
/***************************************************************/
$params = explode('-',h($xRoutes[1]));
$produsID = (int) $params[0];
$xProdus = @getRec("SELECT * FROM produse WHERE activ >= 1 AND id_produs = '".$produsID."' LIMIT 1");
if($xProdus['id_produs'] < 1){ @goRedirect('./'); die(); }

/***************************************************************/
$pag->SEO($xProdus['produsul'],$xProdus['seo_meta_keys'],$xProdus['seo_meta_desc']);
@mysqli_query($con,"UPDATE produse SET total_accesari=total_accesari+1 WHERE id_produs = '".$xProdus['id_produs']."' LIMIT 1;");
@mysqli_query($con,"OPTIMIZE TABLE categorii, produse, produse_imagini, produse_reviews;"); // Optimizare tabele
/***************************************************************/
$bc = new Breadcrumb('Detalii produs');
/***************************************************************/
/** AFISARE CATEGORIE PRODUS ***/
if($xProdus['id_cat_1'] > 0){
  $tempoCat = @getRec("SELECT * FROM categorii WHERE activ >= 1 AND id_cat = '".$xProdus['id_cat_1']."' LIMIT 1;");
  if($tempoCat['id_cat'] >= 1)
  {
    $link_url = 'catalog/'.$tempoCat['id_cat'].'-'.Text2URL(trim($tempoCat['categoria'])).'.html';
    $bc->addItem(trim($tempoCat['categoria']),$link_url);
  }
}
/***************************************************************/
$bc->addItem($xProdus['produsul']);
$bc->getHTML();
/***************************************************************/
$xProdus['intro'] = substr($xProdus['info'],0,462)." ...</p>";
$pag->assign('xProdus',$xProdus); // BINDATE INFORMATII produs
/***************************************************************/
$btnPoze = ''; $listaPoze = ''; $k = 1;
/***************************************************************/
/** POZA PRINCIPALA PRODUS */
if(file_exists($xProdus['vpath'].$xProdus['file_name']))
{
  $btnPoze.= '<button class="nav-link active" id="nav-'.$k.'-tab" data-bs-toggle="tab" data-bs-target="#nav-'.$k.'" ';
  $btnPoze.= 'type="button" role="tab" aria-controls="nav-'.$k.'" aria-selected="true">';
  $btnPoze.= '<img src="'.$xProdus['vpath'].$xProdus['file_name'].'" alt="POZA"></button>'."\n";

  $listaPoze.= '<div class="tab-pane fade show active" id="nav-'.$k.'" role="tabpanel" aria-labelledby="nav-'.$k.'-tab" tabindex="0">
  <div class="w-product-details-nav-main-thumb"><img src="'.$xProdus['vpath'].$xProdus['file_name'].'" alt="POZA"></div>
  </div>'."\n";
}
/***************************************************************/
$rezux = @mysqli_query($con,"SELECT * FROM produse_imagini WHERE activ >= 1 AND id_produs = '".$xProdus['id_produs']."' ORDER BY nivel ASC");
while($row = @mysqli_fetch_assoc($rezux)){
  $k += 1;

  if(file_exists($row['vpath'].$row['file_name']) && $row['file_name'] !== '')
  {
    $btnPoze.= '<button class="nav-link" id="nav-'.$k.'-tab" data-bs-toggle="tab" data-bs-target="#nav-'.$k.'" ';
    $btnPoze.= 'type="button" role="tab" aria-controls="nav-'.$k.'" aria-selected="false">';
    $btnPoze.= '<img src="'.$row['vpath'].$row['file_name'].'" alt="POZA">';
    $btnPoze.= '</button>'."\n";

    $listaPoze.= '<div class="tab-pane fade" id="nav-'.$k.'" role="tabpanel" aria-labelledby="nav-'.$k.'-tab" tabindex="0">
    <div class="w-product-details-nav-main-thumb"><img src="'.$row['vpath'].$row['file_name'].'" alt="POZA"></div>
    </div>'."\n";
  }
}
@mysqli_free_result($rezux);
/***************************************************************/
$pag->assign('btnPoze',$btnPoze); // Bindare butoane POZE
$pag->assign('listaPoze',$listaPoze); // Bindare lista POZE
/***************************************************************/
if($xProdus['discount'] >= 1){
  /** DACA ARE DISCOUNT */
  $preturi = '<h4 class="badge bg-danger">Discount '.$xProdus['discount'].' %</h4>
  <br><span class="w-product-details-price old-price me-2">'.$xProdus['pret_init'].'</span>
  <span class="w-product-details-price new-price">'.$xProdus['pret_final'].' LEI</span>'; 
} else {
  /** DACA NU ARE DISCOUNT */
  $preturi = '<span class="w-product-details-price new-price">'.$xProdus['pret_final'].' LEI</span>'; 
}

$pag->assign('preturi',$preturi); // Bindare Preturi produs
/***************************************************************/
$ALTE_PRODUSE = ''; $sql = "SELECT * FROM produse WHERE activ >= 1 AND id_cat_1 = '".$xProdus['id_cat_1']."' ".
" AND id_produs <> '".$xProdus['id_produs']."' ORDER BY RAND()  LIMIT 0,9;";
$rezux = @mysqli_query($con, $sql); $totalAltele = @mysqli_num_rows($rezux);
while( $row = @mysqli_fetch_assoc($rezux)) 
{
  $produs = new ProdusSimilar($row['id_produs']);
  $ALTE_PRODUSE.= $produs->getHTML();
} 
@mysqli_free_result($rezux);
$pag->assign('ShowAltele',(int) $totalAltele);
$pag->assign('ALTE_PRODUSE',$ALTE_PRODUSE);
/***************************************************************/