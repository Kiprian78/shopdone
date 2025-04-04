<?php
/***************************************************************************************************/
function h($val=""){ 
  return htmlentities(trim($val), ENT_QUOTES, "UTF-8"); 
}
/***************************************************************************************************/
function Text2URL($initial = "",$len=180)
{ 
  $initial = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $initial);    
  $cautare 	= array('__','(',')','*','.','\\','/','?','!','"','`',"'",',',':','&', '%','!',';','_','+',
               '«','»','__','"','"','ţ','ş','î','â','ă','Ţ','Ş','Î','Â','Ă',' ','--');						  
  $inlocuire 	= array('-','','','','','','-','','','','','','','','','','','','','','','','-','','','t',
               's','i','a','a','T','S','I','A','A','-','-');  
  $output = str_replace($cautare,$inlocuire,$initial); 
  
  return (string) substr(strtolower($output),0,$len);
}
/***************************************************************************************************/
function xStrong($text = "")
{ 
  return '<strong>'.$text.'</strong>';
}
/***************************************************************************************************/
function xGenul($value = 'F')
{ 
  return ($value == 'F' ? "Feminin" : "Masculin"); 
}
/***************************************************************************************************/
function xActiv($value = 0)
{ 
  return ($value > 0 ? "DA" : "NU"); 
}
/***************************************************************************************************/
function xActivBold($value = 0)
{ 
  return '<strong>'.($value > 0 ? "DA" : "NU").'</strong>'; 
}
/***************************************************************************************************/
function xDate($initial = ""){ 
  return (substr($initial,0,2)=='00'?'-':date("d.m.Y",strtotime($initial))); 
}  
/***************************************************************************************************/
function xDateTime($initial = "")
{ 
  return (substr($initial,0,2)=='00'?'-':date("d.m.Y H:i:s",strtotime($initial))); 
}  
/***************************************************************************************************/
function roDATA($data = "", $showOra = false,$showZiSaptamana = true)
{
  $output = "";	$zile_sapt = array('Duminică','Luni','Marți','Miercuri','Joi','Vineri','Sâmbătă');
  $lunile_an = array('','Ianuarie','Februarie','Martie','Aprilie','Mai','Iunie','Iulie',
                     'August','Septembrie','Octombrie','Noiembrie','Decembrie');
  $output = ($showZiSaptamana ? $zile_sapt[date("w",strtotime($data))].", " : '').
  date("d",strtotime($data))." ".$lunile_an[date("n",strtotime($data))].", ".date("Y",strtotime($data));
  
  if($showOra){ 
    $output .= " ".date("H:i",strtotime($data)); 
  }  
  if( substr($data,0,4) == '0000'){ 
    $output = '-'; 
  }	
  return (string) $output; 
}
/***************************************************************************************************/
function xAge($data="")
{ 
  $age=date("Y"); 
  $anul=date("Y",strtotime($data)); 
  $age=$age-$anul; 
  return '<b>'.$age.'</b> ani';
}
/***************************************************************************************************/
function xListValue($key='',$lista=array()){ 
    return $lista[$key]; 
}
/***************************************************************************************************/
function xListValueBold($key='',$lista=array())
{ 
  return '<strong>'.$lista[$key].'</strong>'; 
}
/***************************************************************************************************/
/***********************************************************/
function genRandomPass($maxLen=8) 
{
  $toate = "@0123456789#abcdefghijklmnopqrstuwxyz@0123456789!0ABCDEFGHIJKLMNOPQRSTUWXYZ@01234567890#ABCDEFGHIJKLMNOPQRSTUWXYZ?";
  $newPass = array(); 
  for ($i=0; $i<$maxLen; $i++)
  { 
      $n = rand(0,strlen($toate)-1); 
      $newPass[$i] = $toate[$n]; 
  }
  return implode($newPass); 
}
/***********************************************************/
function genLoginPass($maxLen=8) 
{
  $toate = "@0123456789#abcdefghijklmnopqrstuwxyz@0123456789!0ABCDEFGHIJKLMNOPQRSTUWXYZ@01234567890#ABCDEFGHIJKLMNOPQRSTUWXYZ?";
  $newPass = array(); 
  for ($i=0; $i<$maxLen; $i++)
  { 
      $n = rand(0,strlen($toate)-1); 
      $newPass[$i] = $toate[$n]; 
  }
  return implode($newPass); 
}
/***********************************************************/