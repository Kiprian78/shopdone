<?php
class Table_Detalii {
/************************************************************************/
public function __construct() 
{
  echo "\n\n".'<table class="table table-sm table-hover w-100 mt-3">'."\n";
}
/************************************************************************/
public function AddRow($label='',$value='',$small=false)
{
  if($small){
    echo '<tr><td width="15%" nowrap class="p-1">'.$label.'</td>
    <td><small>'.$value.'</small></td></tr>'."\n";
  } else {
  echo '<tr><td width="15%" nowrap class="p-1">'.$label.'</td>
  <td><strong>'.$value.'</strong></td></tr>'."\n";
  }
  return $this;
}
/************************************************************************/
public function Done(){
echo '</table>'."\n\n"; }
/************************************************************************/
}