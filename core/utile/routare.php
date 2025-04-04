<?php
/****************************************************************************/
function getURLRoutes() 
{
  $tmp = htmlentities(trim($_SERVER['REQUEST_URI']));
  $tmp = substr($tmp,1,strlen($tmp));
  $tmp = str_replace(trim(WEB_DOMENIU),"",$tmp);
  $tmp = str_replace('.html','',addslashes(trim($tmp)));
  $tmp = (array) explode("/",trim($tmp));
  for($i=0; $i<count($tmp); $i++){  if(trim($tmp[$i])==""){ unset($tmp[$i]); }} 
  return (array) $tmp; 
}
/****************************************************************************/
function goRedirect($catreURL='./',$secunde=0)
{
  $redirect_url = trim(WEB_BASE_URL).$catreURL;  

  $output = '<html><head>';
  $output.= '<meta http-equiv="refresh" content="'.$secunde.';URL='.$redirect_url.'">';
  $output.= '</head><body></body></html>'; 

  die($output); 
}
/****************************************************************************/