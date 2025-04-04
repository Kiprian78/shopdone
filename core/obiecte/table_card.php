<?php
class Table_Card {
/************************************************************************/
private $width = 5;
private $nowrap = true;
/************************************************************************/
public function __construct($cMob=12,$cDsk=6,$xTitle='',$mb=4) 
{
echo "\n\n".'<div class="col-'.$cMob.' col-lg-'.$cDsk.' mb-'.$mb.'">
<div class="card rounted"><div class="card-body">'."\n";
echo '<h5 class="card-title fw-bold">'.$xTitle.':</h5>
<div class="table-responsive">
<table class="table table-striped table-sm w-100"><tbody>'."\n";
}
/************************************************************************/
public function xCol($colLeft=5,$noWrap=true)
{
  $this->width = $colLeft;
  $this->nowrap = $noWrap;

}
/************************************************************************/
public function xRow($label='',$value='',$cssText='dark')
{
  echo '<tr><td width="'.$this->width.'%" '.($this->nowrap ? 'nowrap' : '');
  echo ' class="p-2">'.$label.'</td>'."\n";
  echo '<td><strong class="text-'.$cssText.'">'.$value.'</strong></td></tr>'."\n";
  return $this;
}
/************************************************************************/
public function Done() { 
echo '</tbody></table></div></div></div></div>'."\n\n"; }
/************************************************************************/
}