<?php
class ProdusCard {
/****************************************************/
private $pid = '';
private $bs5CSS = array();
private $produs = array();
private $link_url = '';
private $stickers = '';
private $preturi = '';
private $images = '';
private $categs = '';
private $html = '';
/****************************************************/
public function __construct($idProdus=0,$colXL=3,$colLG=4,$colSM=6,$mb=3) 
{ 
  global $con; 
  $this->pid = (int) $idProdus;
  $this->produs = @getRec("SELECT * FROM produse WHERE id_produs = '".$this->pid."' LIMIT 1;");

  $this->bs5CSS = array('XL'=>'col-xl-'.$colXL,
                        'LG'=>'col-lg-'.$colLG,
                        'SM'=>'col-sm-'.$colSM,
                        'mb'=>'mb-'.$mb);

  if($this->produs['id_produs'] >= 1)
  {
    $this->link_url = 'produs/'.$this->produs['id_produs'].'-'.Text2URL($this->produs['produsul']).'/'; 
    $this->get_images();
    $this->get_stickers();
    $this->get_categorii(); 
    $this->procesare();
  }

}
/****************************************************/
private function procesare()
{
  $cssDiv = $this->bs5CSS['XL']." ".$this->bs5CSS['LG']." ".$this->bs5CSS['SM']." ".$this->bs5CSS['mb'];
  $this->html = "\n\n".'<div class="'.$cssDiv.'">';
  $this->html.= '<div class="w-product-item p-relative transition-3 mb-25">';
  $this->html.= '<div class="w-product-thumb p-relative fix m-img">';
  $this->html.= '<a href="'.$this->link_url.'">';
  $this->html.= $this->images;
  $this->html.= '</a><div class="w-product-badge">';
  $this->html.= $this->stickers;  
  $this->html.= '</div></div>';
  $this->html.= '<div class="w-product-content"><div class="w-product-category">';
  $this->html.= $this->categs;
  $this->html.= '</div><h3 class="w-product-title">';
  $this->html.= '<a href="'.$this->link_url.'" title="'.h($this->produs['produsul']).'">'.trim($this->produs['produsul']).'</a>';
  $this->html.= '</h3><div class="w-product-rating d-flex align-items-center"><div class="w-product-rating-icon">';
  $this->html.= '<span><i class="fa-solid fa-star"></i></span>
  <span><i class="fa-solid fa-star"></i></span>
  <span><i class="fa-solid fa-star"></i></span>
  <span><i class="fa-solid fa-star"></i></span>
  <span><i class="fa-solid fa-star-half-stroke"></i></span>';
  $this->html.= '</div><div class="w-product-rating-text"><span>(2 Reviews)</span></div></div>';
  $this->html.= '<div class="w-product-price-wrapper">';
  $this->html.= $this->preturi;
  $this->html.= '</div></div></div></div>'."\n\n";
}
/****************************************************/
private function get_stickers()
{
  $this->preturi = '';
  $this->stickers = '';

  if($this->produs['discount'] > 0){
    $this->stickers.= '<span class="product-hot">-'.$this->produs['discount'].'%</span>';
    $this->preturi.= '<span class="w-product-price old-price me-2">'.$this->produs['pret_init'].'</span>';
    $this->preturi.= '<span class="w-product-price new-price">'.$this->produs['pret_final'].' LEI</span>';
  } else {
    $this->preturi.= '<span class="w-product-price new-price">'.$this->produs['pret_final'].' LEI</span>';
  }

  if($this->produs['is_unicat'] > 0){
    $this->stickers.= '<span class="product-trending ms-2">UNICAT</span>';

  }


  /**
   <span class="product-hot">-25%</span>
  <span class="product-trending">NOU</span>
  <span class="product-offer">PREMIUM</span>
  <span class="product-sale">HOT</span>
   */

}
/****************************************************/
private function get_images()
{
$file_x = 'assets/images/no-image.jpg';  
$file_1 = $this->produs['file_name'];
$vpath  = $this->produs['vpath'];  
$this->images = '';

  if(file_exists($vpath.$file_1) && $file_1 !== ''){
    $this->images.= '<img src="'.$vpath.$file_1.'" alt="PREVIEW">';
  } else {
    $this->images.= '<img src="'.$vpath.$file_x.'" alt="PREVIEW">';
  }

}
/****************************************************/
private function get_categorii()
{
  $this->categs = '';

  if($this->produs['id_cat_1'] > 0){
    $tempoCat = @getRec("SELECT * FROM categorii WHERE activ >= 1 AND id_cat = '".$this->produs['id_cat_1']."' LIMIT 1;");
    if($tempoCat['id_cat'] >= 1){
      $link_url = 'catalog/'.$tempoCat['id_cat'].'-'.Text2URL(trim($tempoCat['categoria'])).'.html';
      $this->categs.= '<a href="'.$link_url.'" class="me-2" style="font-size: 13px !important;">'.trim($tempoCat['categoria']).'</a> ';
    }
  }

  if($this->produs['id_cat_2'] > 0){
    $tempoCat = @getRec("SELECT * FROM categorii WHERE activ >= 1 AND id_cat = '".$this->produs['id_cat_2']."' LIMIT 1;");
    if($tempoCat['id_cat'] >= 1){
      $link_url = 'catalog/'.$tempoCat['id_cat'].'-'.Text2URL(trim($tempoCat['categoria'])).'.html';
      $this->categs.= '<a href="'.$link_url.'" class="me-2" style="font-size: 13px !important;">'.trim($tempoCat['categoria']).'</a> ';
    }
  }
/*
  if($this->produs['id_cat_3'] > 0){
    $tempoCat = @getRec("SELECT * FROM categorii WHERE activ >= 1 AND id_cat = '".$this->produs['id_cat_3']."' LIMIT 1;");
    if($tempoCat['id_cat'] >= 1){
      $link_url = 'catalog/'.$tempoCat['id_cat'].'-'.Text2URL(trim($tempoCat['categoria'])).'.html';
      $this->categs.= '<a href="'.$link_url.'" class="me-2" style="font-size: 13px !important;">'.trim($tempoCat['categoria']).'</a> ';
    }
  }
*/    
}
/****************************************************/
public function getHTML(){
  return (string) $this->html; 
}
/****************************************************/
}