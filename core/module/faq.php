<?php
/*****************************************************************************/
$selTM = $pag->getTM(22);
/*****************************************************************************/
$bc = new Breadcrumb($selTM['meniul']);
$bc->addItem($selTM['meniul']);
$bc->getHTML();
/*****************************************************************************/
$PAGE_CONTEXT = ''; $k = 0;
$sql = "SELECT * FROM faq WHERE activ >= 1 ORDER BY nivel ASC";
$rezux = @mysqli_query($con, $sql); $total = @mysqli_num_rows($rezux);
if($total < 1){ 
  $PAGE_CONTEXT.= '<p class="text-center">Nu sunt rezultate de afisat.</p>'; 
} else {
  $PAGE_CONTEXT.= '<div class="accordion mb-3" id="accFaq">'."\n"; 
}

while($row = @mysqli_fetch_assoc($rezux))
{
  $k++;
  $antet = 'heading'.$k; $body = 'collapse'.$k;
  $css_antet = 'collapsed';  //$css_antet = ($k < 2 ? 'collapsed show' : 'collapsed');
  $css_body = 'collapse';    //$css_body = ($k < 2 ? 'collapsed show' : 'collapse');
  
  $PAGE_CONTEXT.= '<div class="accordion-item">'.
  '<h2 class="accordion-header" id="'.$antet.'">'.
  '<button class="accordion-button '.$css_antet.'" type="button" data-bs-toggle="collapse" data-bs-target="#'.$body.'" aria-expanded="'.($k<2?'true':'false').'" aria-controls="collapseOne">'.
  '<i class="fa-regular fa-circle-question me-3"></i><strong>'.trim($row['intrebarea']).'</strong></button></h2>';

  $PAGE_CONTEXT.= '<div id="'.$body.'" class="accordion-collapse '.$css_body.'" aria-labelledby="'.$antet.'" data-bs-parent="#accFaq">
  <div class="accordion-body pb-5">'.trim($row['raspunsul']).'</div>
  </div></div>'."\n";


}

@mysqli_free_result($rezux);

if($total >= 1){
  $PAGE_CONTEXT.= '</div>'."\n"; 
}
$pag->assign('PAGECONTEXT',$PAGE_CONTEXT);
/*****************************************************************************/
$incTPL = 'faq.tpl';
/*****************************************************************************/
