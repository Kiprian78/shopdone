<?php
class Produs {
/*************************************************/
private $pid = '';
private $produs = array();
private $link_url = '';
private $images = '';
private $categs = '';
private $html = '';
/*************************************************/
public function __construct($idProd=0) 
{ 
  global $con; 
  $this->pid = (int) $idProd;
  $this->produs = @getRec("SELECT * FROM produse WHERE id_produs = '".$this->pid."' LIMIT 1;");

  if($this->produs['id_produs'] >= 1)
  {
    $this->link_url = 'produs/'.$this->produs['id_produs'].'-'.Text2URL($this->produs['produsul']).'/'; 
    $this->get_images();
    $this->get_categorii(); 
    $this->procesare();
  }

}
/*************************************************/
private function procesare()
{
  $this->html = "\n\n".'<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">';
  $this->html.= '<div class="w-product-item-2 mb-40">';          
  $this->html.= '<div class="w-product-thumb-2 p-relative z-index-1 fix w-img">';
  $this->html.= '<a href="'.$this->link_url.'">';
  $this->html.= $this->images;
  $this->html.= '</a></div>';
  $this->html.= '<div class="w-product-content-2 pt-15">';
  $this->html.= '<div class="w-product-tag-2">';
  $this->html.= $this->categs;
  $this->html.= '</div><h3 class="w-product-title-2">';
  $this->html.= '<a href="'.$this->link_url.'" title="'.h($this->produs['produsul']).'">'.trim($this->produs['produsul']).'</a>';
  $this->html.= '</h3>'."\n";

  $this->html.= '<div class="w-product-rating-icon w-product-rating-icon-2">
  <span><i class="fa-solid fa-star"></i></span><span><i class="fa-solid fa-star"></i></span>
  <span><i class="fa-solid fa-star"></i></span><span><i class="fa-solid fa-star"></i></span>
  <span><i class="fa-solid fa-star"></i></span></div>';

  $this->html.= '<div class="w-product-price-wrapper-2">';
  $this->html.= '<span class="w-product-price-2 old-price me-2">'.$this->produs['pret_init'].'</span>';
  $this->html.= '<span class="w-product-price-2 new-price"><strong>'.$this->produs['pret_final'].'</strong> LEI</span>';
  $this->html.= '</div></div>';

  $this->html.= '</div></div>'."\n\n";
}
/*************************************************/
private function get_images()
{
$file_x = 'assets/images/no-image.jpg';  
$file_1 = $this->produs['file_name'];
$vpath  = $this->produs['vpath'];  
$this->images = '';

if(file_exists($vpath.$file_1) && $file_1 !== ''){
  $this->images.= '<img src="'.$vpath.$file_1.'" alt="">';
} else {
  $this->images.= '<img src="'.$vpath.$file_x.'" alt="">';
}

}
/*************************************************/
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

  if($this->produs['id_cat_3'] > 0){
    $tempoCat = @getRec("SELECT * FROM categorii WHERE activ >= 1 AND id_cat = '".$this->produs['id_cat_3']."' LIMIT 1;");
    if($tempoCat['id_cat'] >= 1){
      $link_url = 'catalog/'.$tempoCat['id_cat'].'-'.Text2URL(trim($tempoCat['categoria'])).'.html';
      $this->categs.= '<a href="'.$link_url.'" class="me-2" style="font-size: 13px !important;">'.trim($tempoCat['categoria']).'</a> ';
    }
  }
}
/*************************************************/
public function getHTML(){
return (string) $this->html; }
/*************************************************/
}