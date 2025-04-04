<?php
class Breadcrumb {
/**************************************************************/
private $html = '';
/**************************************************************/
public function __construct($antetul='NAME',$addHome=true)
{
  $this->html = "\n".'<!-- Begin BREADCRUMB -->'."\n";
  $this->html.= '<section class="breadcrumb__area text-center pt-45 pb-25 mb-40">'."\n";
  $this->html.= '<div class="container"><div class="row"><div class="col-xxl-12">'."\n";
  $this->html.= '<div class="breadcrumb__content p-relative z-index-1">';
  $this->html.= '<h3 class="breadcrumb__title color1-tema">'.trim($antetul).'</h3>';
  $this->html.= '<div class="breadcrumb__list">';

  if($addHome){ 
    $this->html.= '<span><a href="./">Acasă</a></span>'."\n"; 
  }
}
/**************************************************************/
public function addItem($label='', $link_url = '')
{
  if($link_url !== ""){
    $this->html.= '<span><a href="'.$link_url.'">'.$label.'</a></span>'."\n";
  } else {
    $this->html.= '<span>'.$label.'</span>'."\n";
  }
}
/**************************************************************/
public function Done()
{
  $this->html.= '</div></div></div></div></div>'."\n";
  $this->html.= '</section>'."\n".'<!-- End BREADCRUMB -->'."\n\n";
}
/**************************************************************/
public function getHTML(){
  global $pag; $this->Done();
  $pag->assign('BREADCRUMB',$this->html);  
}
/**************************************************************/
}