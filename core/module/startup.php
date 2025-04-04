<?php
/*****************************************************************************/
$selTM = $pag->getTM(1);
/*****************************************************************************/
$hpBanere = ''; $sql = "SELECT * FROM hp_banere WHERE activ >= 1 ORDER BY nivel ASC";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux);
if($total >= 1) {
  $hpBanere.= '<!-- BEGIN SECTIUNE BANERE -->'."\n";
  $hpBanere.= '<section class="w-banner-area pb-40 pt-50">'."\n";
  $hpBanere.= '<div class="container"><div class="row">'."\n";
}
while($row = @mysqli_fetch_assoc($rezux)) 
{
  $baner_image = $row['vpath'].$row['file_name'];
  $baner_linkurl = $row['link_url'];
  $baner_info = $row['baner'];

  if($row['model'] == 'Big')
  {
    $hpBanere.= '<div class="col-xl-8 col-lg-7"><a href="'.$baner_linkurl.'" target="_blank" title="'.h($baner_info).'">';
    $hpBanere.= '<div class="w-banner-item w-banner-height p-relative mb-30 z-index-0 fix">';
    $hpBanere.= '<div class="w-banner-thumb include-bg transition-3" data-background="'.$baner_image.'"></div>';
    $hpBanere.= '<div class="w-banner-content"><!-- '.$baner_info.' --></div>';
    $hpBanere.= '</div></a></div>';
  } 
  else 
  {
    $hpBanere.= '<div class="col-xl-4 col-lg-5"><a href="'.$baner_linkurl.'" target="_blank" title="'.h($baner_info).'">';
    $hpBanere.= '<div class="w-banner-item w-banner-height p-relative mb-30 z-index-1 fix">';
    $hpBanere.= '<div class="w-banner-thumb include-bg transition-3" data-background="'.$baner_image.'"></div>';
    $hpBanere.= '<div class="w-banner-content"></div>';
    $hpBanere.= '</div></a></div>';
  }
} 
@mysqli_free_result($rezux);

if($total >= 1) {
  $hpBanere.= '</div></div></section>';
  $hpBanere.= '<!-- END SECTIUNE BANERE -->'."\n\n";
}
$pag->assign('hpBanere',$hpBanere);
/*****************************************************************************/
$hpBlog = array(); $sql = "SELECT * FROM blog_articole WHERE activ >= 1 ORDER BY date_pub DESC LIMIT 0,5";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux); $k = 0;
while($row = @mysqli_fetch_assoc($rezux)) 
{
  $hpBlog[$k] = $row;
  $hpBlog[$k]['link_url'] = 'noutati/'.$row['id_blog'].'-'.Text2URL(substr(trim($row['art_title']),0,65)).'.html';
  $hpBlog[$k]['date_pub'] = xDate($row['date_pub']);
  $info = strip_tags($row['art_info']);
  $hpBlog[$k]['info'] = substr($info,0,123)."...";
  $hpBlog[$k]['read_more'] = "Citeste mai mult";

  if(file_exists($row['vpath'].$row['file_name']) && $row['file_name'] !== ''){
    $hpBlog[$k]['imaginea'] = $row['vpath'].$row['file_name'];
  } else { 
    $hpBlog[$k]['imaginea'] = 'assets/images/fara-categorie.jpg'; 
  }

  $k++;
} @mysqli_free_result($rezux);
$pag->assign('showBlog',$k);
$pag->assign('hpBlog',$hpBlog);
/*****************************************************************************/
$hpCategorii = ''; $sql = "SELECT * FROM categorii WHERE activ >= 1 AND id_root_cat < 1 ORDER BY nivel ASC";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux); $k = 0;
if($total >= 1) { $hpCategorii = '<!-- BEGIN CATEGORII PRODUSE -->
<section class="w-product-category pt-60 pb-15"><div class="container"><div class="row row-cols-xl-6 row-cols-lg-6 row-cols-md-4">'."\n"; }
while($row = @mysqli_fetch_assoc($rezux)) 
{
  if(file_exists($row['vpath'].$row['file_name']) && $row['file_name'] !== ''){
    $imaginea = $row['vpath'].$row['file_name'];
  } else { $imaginea = 'assets/images/fara-categorie.jpg'; }

  $categoria = trim($row['categoria']);
  $link_url = 'catalog/'.$row['id_cat'].'-'.Text2URL(trim($row['categoria'])).'.html';
  $contor = @getRec("SELECT COUNT(*) as x FROM produse WHERE activ >= 1 AND '".$row['id_cat']."' IN (id_cat_1,id_cat_2,id_cat_3) LIMIT 1;");
  $contor = (int) $contor['x'];

  $hpCategorii.= '<div class="col"><div class="w-product-category-item text-center mb-40">';
  $hpCategorii.= '<div class="w-product-category-thumb fix"><a href="'.$link_url.'"><img src="'.$imaginea.'" alt="Categorie"></a>';
  $hpCategorii.= '</div><div class="w-product-category-content"><h3 class="w-product-category-title">';
  $hpCategorii.= '<a href="'.$link_url.'">'.$categoria.'</a></h3><p><strong>'.$contor.'</strong> produse</p>';
  $hpCategorii.= '</div></div></div>'."\n\n";

} @mysqli_free_result($rezux);

if($total >= 1) { $hpCategorii.= '</div></div></section>
<!-- END CATEGORII PRODUSE -->'."\n\n"; }
$pag->assign('hpCategorii',$hpCategorii);
/*****************************************************************************/
$boxFeatures = array(); $sql = "SELECT * FROM hp_features WHERE activ >= 1 ORDER BY nivel ASC";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux); $k = 0;
while($row = @mysqli_fetch_assoc($rezux)) {
  $boxFeatures[$k] = $row; $k+=1;
} @mysqli_free_result($rezux);
$pag->assign('showFeatures',$k);
$pag->assign('boxFeatures',$boxFeatures);
/*****************************************************************************/
$PRODUSE_NOI = ''; $sql = "SELECT * FROM produse WHERE activ >= 1 AND discount < 1 ORDER BY data_add DESC LIMIT 0,8;";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux);
while( $row = @mysqli_fetch_assoc($rezux)) 
{
  $produs = new ProdusCard($row['id_produs']);
  $PRODUSE_NOI.= $produs->getHTML();
} 
@mysqli_free_result($rezux);
$pag->assign('PRODUSE_NOI',$PRODUSE_NOI);
/*****************************************************************************/
$PRODUSE_PROMO = ''; $sql = "SELECT * FROM produse WHERE activ >= 1 AND discount >= 1 ORDER BY discount DESC LIMIT 0,8;";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux);
while( $row = @mysqli_fetch_assoc($rezux)) 
{
  $produs = new ProdusCard($row['id_produs']);
  $PRODUSE_PROMO.= $produs->getHTML();
} 
@mysqli_free_result($rezux);
$pag->assign('PRODUSE_PROMO',$PRODUSE_PROMO);
/*****************************************************************************/
$PRODUSE_TOPSELL = ''; $sql = "SELECT * FROM produse WHERE activ >= 1 AND total_sell >= 0 ORDER BY RAND() DESC LIMIT 0,8;";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux);
while( $row = @mysqli_fetch_assoc($rezux)) 
{
  $produs = new ProdusCard($row['id_produs']);
  $PRODUSE_TOPSELL.= $produs->getHTML();
} 
@mysqli_free_result($rezux);
$pag->assign('PRODUSE_TOPSELL',$PRODUSE_TOPSELL);
/*****************************************************************************/
$PRODUSE_RECOMANDATE = ''; $sql = "SELECT * FROM produse WHERE activ >= 1 ORDER BY RAND() DESC LIMIT 0,8;";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux);
while( $row = @mysqli_fetch_assoc($rezux)) 
{
  $produs = new ProdusRecomand($row['id_produs']);
  $PRODUSE_RECOMANDATE.= $produs->getHTML();
} 
@mysqli_free_result($rezux);
$pag->assign('PRODUSE_RECOMANDATE',$PRODUSE_RECOMANDATE);
/*****************************************************************************/
$OFERTELE_ZILEI = ''; $sql = "SELECT * FROM produse WHERE activ >= 1 AND discount >= 1 ORDER BY discount DESC LIMIT 0,7;";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux);
while( $row = @mysqli_fetch_assoc($rezux)) 
{
  $oferta = new OfertaZilei($row['id_produs']);
  $OFERTELE_ZILEI.= $oferta->getHTML();
} 
@mysqli_free_result($rezux);
$pag->assign('OFERTELE_ZILEI',$OFERTELE_ZILEI);
/*****************************************************************************/
$hpSLIDER = ''; $sql = "SELECT * FROM hp_slider WHERE activ >= 1 ORDER BY nivel ASC";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux);
if($total >= 1){
  $hpSLIDER = '<!-- BEGIN HP SLIDER -->'."\n";
  $hpSLIDER.= '<section class="w-slider-area p-relative z-index-1">';
  $hpSLIDER.= '<div class="w-slider-active w-slider-variation swiper-container">';
  $hpSLIDER.= '<div class="swiper-wrapper">';
}
while( $row = @mysqli_fetch_assoc($rezux)) 
{
  $imaginea = trim($row['vpath'].$row['file_name']);

  $hpSLIDER.= '<div class="w-slider-item is-light w-slider-height d-flex align-items-center swiper-slide" data-bg-color="#E3EDF6">';
  $hpSLIDER.= '<div class="container"><div class="row align-items-center"><div class="col-xl-5 col-lg-6 col-md-6">';
  $hpSLIDER.= '<div class="w-slider-content p-relative z-index-1">'."\n";
  if(trim($row['small_text']) !== ""){
  $hpSLIDER.= '<span>'.trim($row['small_text']).'</span>'."\n"; }
  if(trim($row['big_text']) !== ""){
  $hpSLIDER.= '<h3 class="w-slider-title">'.trim($row['big_text']).'</h3>'."\n"; }                     
  if(trim($row['price_text']) !== ""){
  $hpSLIDER.= '<p>'.trim($row['price_text']).'</p>'."\n"; }
  if($row['has_buton'] >= 1){
  $hpSLIDER.= '<div class="w-slider-btn"><a href="'.trim($row['btn_link_url']).'" class="w-btn w-btn-2 w-btn-white">'.trim($row['btn_label']).'
  <span><i class="fa-solid fa-arrow-right ms-2"></i></span></a></div>'; }

  $hpSLIDER.= '</div></div><div class="col-xl-7 col-lg-6 col-md-6">';
  $hpSLIDER.= '<div class="w-slider-thumb text-end"><img src="'.$imaginea.'" alt="slider-img" class="rounded"></div>';
  $hpSLIDER.= '</div></div></div></div>'."\n\n";

}
@mysqli_free_result($rezux);
if($total >= 1){
  $hpSLIDER.= '</div>'."\n";
  $hpSLIDER.= '<div class="w-slider-arrow w-swiper-arrow d-none d-lg-block"><button type="button" class="w-slider-button-prev">';
  $hpSLIDER.= '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">';
  $hpSLIDER.= '<path d="M7 13L1 7L7 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>';
  $hpSLIDER.= '</svg></button><button type="button" class="w-slider-button-next">';
  $hpSLIDER.= '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">';
  $hpSLIDER.= '<path d="M1 13L7 7L1 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>';
  $hpSLIDER.= '</svg></button></div><div class="w-slider-dot w-swiper-dot"></div></div></section>'."\n";
  $hpSLIDER.= '<!-- END HP SLIDER -->'."\n\n";
}
$pag->assign('HPSLIDER',$hpSLIDER);
/*****************************************************************************/