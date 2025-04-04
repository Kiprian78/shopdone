<?php
/**************************************************************************************************/
class WebPage extends Sabloane {
/**************************************************************************************************/
public $ws_config	= array();
/**************************************************************************************************/
public function __construct() 
{
	parent::__construct();
	$this->template_dir = trim(INC_SABLOANE);
	$this->assign('WEBSITE_URL',WEB_BASE_URL);
	$this->assign('PAGE_TITLE', WEB_NAME);
	$this->assign('CSRF_TOKEN',CSRF::getToken());	
	$this->assign('HEAD_SHARE','');	
	$this->get_configuratie();
	$this->ListaCategorii();
	$this->TopMeniu();
	$this->getFooterMenus();
	$this->getSocialMedia();
	$this->PozeFooter();
	$this->set_contor_vizitatori();
	$this->ListaCosulMeu();
}
/**************************************************************************************************/
private function get_configuratie()
{
	global $con; $WS_CONFIG = array();
	$rezux = @mysqli_query($con,"SELECT * FROM x_configuratie ORDER BY grupa ASC, keya ASC");	
	while($row = @mysqli_fetch_assoc($rezux))
	{
	   switch($row['tip'])
	   {	
			case 'IMAGE':					
			$vpath = $row['def_folder']; $file_name = $row['value_'];	
			$default_file_name = $row['def_file_name'];	
			if(file_exists($vpath.$file_name) && $file_name != ""){
			$imaginea = $vpath.$file_name;	}	else { $imaginea = $vpath.$default_file_name;	}
			$WS_CONFIG[$row['keya']] = $imaginea;
			break;

			case 'TA':	   
			$WS_CONFIG[$row['keya']] = nl2br($row['value_']);
			break;
	
			case 'TEL':	   
			$WS_CONFIG[$row['keya']] = trim($row['value_']);
			$WS_CONFIG[$row['keya'].'_call'] = str_replace(' ','',$row['value_']);
			break;			

	   	default:	   
	  	$WS_CONFIG[$row['keya']] = $row['value_'];
		  break;					
	   }
	}
	@mysqli_free_result($rezux);
	$this->ws_config = $WS_CONFIG;	
	$this->assign('ws_config',$WS_CONFIG);
	$this->assign('WEBSITE_NAME',WEB_NAME);
	$this->assign('ANUL',date("Y"));
}
/**************************************************************************************************/
private function set_contor_vizitatori()
{		
	@include_once("vizitatori_online.php");
	$xvo = new Vizitatori_Online();
	$this->assign('data_ora_acum',roData(date("Y-m-d H:i:s"),true));
	$this->assign('year_now', date("Y"));				
}
/**************************************************************************************************/
public function SEO($pt = "", $mk = "", $md = "") {
	$this->assign('PAGE_TITLE',$pt);
	$this->assign('META_KEYS',str_replace("\r","",strip_tags($mk)));
	$this->assign('META_DESC',str_replace("\r","",strip_tags($md)));
}
/**************************************************************************************************/
public function getTM($idTM=0){
	global $con; $tm = array(); $tm = @getRec("SELECT * FROM top_meniu WHERE activ >= 1 AND id_tm = '".$idTM."' LIMIT 1;");
	if($tm['id_tm'] == $idTM && $idTM > 0){ $this->SEO($tm['seo_page_title'],$tm['seo_meta_desc'],$tm['seo_meta_keys']); }
	return (array) $tm; }
/**************************************************************************************************/
public function ListaCategorii()
{
	global $con; $idx = 0; $html = '';
	$sql = "SELECT *,(SELECT COUNT(*) FROM categorii c WHERE c.activ >= 1 AND c.id_root_cat=categorii.id_cat LIMIT 1) as x ".
	"FROM categorii WHERE activ >= 1 AND id_root_cat < 1 ORDER BY nivel ASC";
	//die($sql);
	$rezux = @mysqli_query($con,$sql); $totals = @mysqli_num_rows($rezux);
	if($totals > 0) { $html.= '<ul>'."\n"; }
	while($row = @mysqli_fetch_assoc($rezux))
	{
		$link_url = 'catalog/'.$row['id_cat'].'-'.Text2URL(trim($row['categoria'])).'.html';

		if($row['x'] >= 1)
		{
			$html.= '<li class="has-dropdown">'."\n";
			$html.= '<a href="#" class="has-mega-menu">'.$row['categoria'].'</a>'."\n";
      $html.= '<ul class="mega-menu w-submenu">'."\n";

			$sqlChild = "SELECT * FROM categorii WHERE activ >= 1 AND id_root_cat = '".$row['id_cat']."' ORDER BY nivel ASC";
			$rezox = @mysqli_query($con,$sqlChild);

			while($rox = @mysqli_fetch_assoc($rezox))
			{
				$clink_url = 'catalog/'.$rox['id_cat'].'-'.Text2URL(trim($rox['categoria'])).'.html';
				$html.= '<li><a href="'.$clink_url.'">'.$rox['categoria'].'</a></li>'."\n";
			}
			@mysqli_free_result($rezox);
			$html.= '</ul></li>'."\n";
		} 
		else 
		{
			$html.= '<li><a href="'.$link_url.'">'.$row['categoria'].'</a></li>'."\n";
		}
	}
	$html.= '<li><a href="promotii/">PROMOȚII</a></li>'."\n";
	$html.= '<li><a href="toate-produsele/">TOATE produsele</a></li>'."\n";

	if($totals > 0) { $html.= '</ul>'."\n"; }
	@mysqli_free_result($rezux);

	$this->assign('ListCategorii',$html);
}
/**************************************************************************************************/
public function TopMeniu()
{
	global $con; $idx = 0; $html = '';
	$sql = "SELECT id_tm,id_root_tm,meniul,tip_meniu,link_url,nivel,activ,".
	"(SELECT COUNT(*) FROM top_meniu WHERE activ >= 1 AND id_root_tm=tm.id_tm LIMIT 1) as x FROM top_meniu tm ".
	"WHERE activ >= 1 AND nivel >= 1 AND id_root_tm < 1 ORDER BY nivel ASC";
	$rezux = @mysqli_query($con,$sql); $totals = @mysqli_num_rows($rezux);
	if($totals > 0) { $html.= '<ul>'."\n"; }
	while($row = @mysqli_fetch_assoc($rezux))
	{
		switch($row['tip_meniu']) 
		{
			default:
			case 'URL': 
			$html.= '<li><a href="'.trim($row['link_url']).'">'.strtoupper($row['meniul']).'</a></li>'."\n"; 
			break;

			case 'CHILD': 
		  if($row['id_tm'] == '8') // daca este CONTUL MEU
			{
				
				$html.= '<li class="has-dropdown">'."\n";
				$html.= '<a href="'.trim($row['link_url']).'">'.strtoupper($row['meniul']).'</a>'."\n";
				$html.= '<ul class="w-submenu">'."\n";
				// Verificam daca CLIENTUL ESTE CONECTAT / LOGIN
				if($_SESSION['CLIENT_ID'] >= 1 && $_SESSION['CLIENT_NAME'] !== "")
				{
					$sqlChild = "SELECT * FROM top_meniu WHERE activ >= 1 AND id_root_tm='".$row['id_tm']."' ORDER BY nivel ASC";
					$rezox = @mysqli_query($con,$sqlChild);
					while($rox = @mysqli_fetch_assoc($rezox))
					{
						$html.= '<li><a href="'.trim($rox['link_url']).'">'.trim($rox['meniul']).'</a></li>';
					}
					@mysqli_free_result($rezox);

				} else {
					// Daca nu este conectat ATUNCI avem:
						$html.= '<li><a href="inregistrare/">Inregistrare cont Nou</a></li>'."\n";
						$html.= '<li><a href="login/">Autentificare Client</a></li>'."\n";
				}
				$html.= '</ul></li>'."\n";

			} else { // Pentru restul meniurilor			
				$html.= '<li class="has-dropdown">'."\n";
				$html.= '<a href="'.trim($row['link_url']).'">'.strtoupper($row['meniul']).'</a>'."\n";
				$html.= '<ul class="w-submenu">'."\n";
				$sqlChild = "SELECT * FROM top_meniu WHERE activ >= 1 AND id_root_tm='".$row['id_tm']."' ORDER BY nivel ASC";
				$rezox = @mysqli_query($con,$sqlChild);
				while($rox = @mysqli_fetch_assoc($rezox))
				{
					$html.= '<li><a href="'.trim($rox['link_url']).'">'.trim($rox['meniul']).'</a></li>';
				}
				@mysqli_free_result($rezox);
				$html.= '</ul></li>'."\n";
			}
			break;

			case 'CATALOG':
			$html.= '<li class="has-dropdown has-mega-menu hide-mobile">'."\n";
			$html.= '<a href="'.trim($row['link_url']).'">'.strtoupper($row['meniul']).'</a>'."\n";
			$html.= '<ul class="w-submenu w-mega-menu mega-menu-style-2">'."\n";
			$html.= '<li class="has-dropdown">'."\n";
			//$html.= '<a href="#" class="mega-menu-title">&nbsp;</a>'."\n";
			$html.= '<ul class="w-submenu">'."\n";

			$sqlChild = "SELECT * FROM categorii WHERE activ >= 1 AND id_root_cat < 1 ORDER BY nivel_catalog ASC";
			$rezox = @mysqli_query($con,$sqlChild);
			while($rox = @mysqli_fetch_assoc($rezox))
			{
				$clink_url = 'catalog/'.$rox['id_cat'].'-'.Text2URL(trim($rox['categoria'])).'.html';
				$html.= '<li><a href="'.$clink_url.'"><strong>'.trim($rox['categoria']).'</strong></a></li>';
			}
			@mysqli_free_result($rezox);

			$html.= '<li><a href="promotii/"><strong>PROMOȚII</strong></a></li>'."\n";
			$html.= '<li><a href="toate-produsele/"><strong>TOATE produsele</strong></a></li>'."\n";			

			$html.= '</ul></li><li class="has-dropdown">
			<!-- <a href="#" class="mega-menu-title"><strong>&nbsp;</strong></a> -->
			<ul class="w-submenu">';

			$sqlChild = "SELECT * FROM categorii WHERE activ >= 1 AND id_root_cat='3' ORDER BY nivel ASC";
			$rezox = @mysqli_query($con,$sqlChild); $total = @mysqli_num_rows($rezox); 
			$split = round($total/2);	$ctr = 0;
			while($rox = @mysqli_fetch_assoc($rezox))
			{
				$ctr += 1;
				$clink_url = 'catalog/'.$rox['id_cat'].'-'.Text2URL(trim($rox['categoria'])).'.html';
				$html.= '<li><a href="'.$clink_url.'">'.trim($rox['categoria']).'</a></li>';

				if($ctr == $split)
				{
					$html.= '</ul></li><li class="has-dropdown">';
					$html.= '<!-- <a href="#" class="mega-menu-title">&nbsp;</a> -->';
					$html.= '<ul class="w-submenu">'."\n"; $ctr = 0;
				}				

			}
			@mysqli_free_result($rezox);

			$html.= '</ul><li class="has-dropdown">'."\n";
			$html.= '<!-- <a href="#" class="mega-menu-title">&nbsp;</a>-->'."\n";
			$html.= '<div class="w-100">'."\n";
			$html.= '<img src="assets/images/poza_catalog.webp" alt="CATALOG" class="img-fluid rounded" />'."\n";
			$html.= '</div>'."\n";
			$html.= '</li></ul></li>'."\n";
			break;
		}
	}

	if($totals > 0) { $html.= '</ul>'."\n"; }
	@mysqli_free_result($rezux);
	$this->assign('xTopMeniu',$html);
}
/**************************************************************************************************/
private function getFooterMenus()
{
 global $con; $ftMeniu1 = ''; $ftMeniu2 = ''; $ftMeniu3 = '';
 $sql = "SELECT * FROM footer_meniu WHERE activ >= 1 ORDER BY sectiunea ASC, nivel ASC";
 $rezux = @mysqli_query($con, $sql);
 while($row = @mysqli_fetch_assoc($rezux))
 {
	$target = ($row['target'] == '_self' ? '' : ' target="_blank"');

	switch($row["sectiunea"])
	{
		default:
		case 's1': $ftMeniu1.= '<li><a href="'.$row['link_url'].'"'.$target.'>'.$row['meniul'].'</a></li>'; break;
		case 's2': $ftMeniu2.= '<li><a href="'.$row['link_url'].'"'.$target.'>'.$row['meniul'].'</a></li>'; break;
		case 's3': $ftMeniu3.= '<li><a href="'.$row['link_url'].'"'.$target.'>'.$row['meniul'].'</a></li>'; break;		
	}
 }	
 @mysqli_free_result($rezux);
 $this->assign('ftMeniu1',$ftMeniu1);
 $this->assign('ftMeniu2',$ftMeniu2);
 $this->assign('ftMeniu3',$ftMeniu3);
}
/**************************************************************************************************/
private function getSocialMedia()
{
	global $con; $xSM = '';
	$sql = "SELECT * FROM social_media WHERE activ >= 1 ORDER BY nivel ASC";
	$rezux = @mysqli_query($con, $sql);
	while($row = @mysqli_fetch_assoc($rezux))
	{
		$xSM.= '<a href="'.$row['link_url'].'" target="_blank" title="'.$row['canal'].'"><i class="'.$row['icoana'].'"></i></a>'."\n";
	}	
	@mysqli_free_result($rezux);
	$this->assign('xSM',$xSM);
}
/**************************************************************************************************/
private function PozeFooter()
{
	global $con; 	$PozeFooter = ''; 
	$sql = "SELECT * FROM footer_poze WHERE activ >= 1 ORDER BY nivel ASC";
	$rezux = @mysqli_query($con, $sql);
	while($row = @mysqli_fetch_assoc($rezux)) 
	{
		$poza = $row['vpath'].$row['file_name'];
		$PozeFooter.= '<div class="col-6 col-lg-6 p-1 m-0"><img src="'.$poza.'" class="img-fluid bPic" alt="Galerie" /></div>'."\n";
	} 
	@mysqli_free_result($rezux);
	$this->assign('PozeFooter',$PozeFooter);
}
/**************************************************************************************************/
private function ListaCosulMeu()
{
	global $con; $html = ''; $subtotal = 0; $total_cos = 0;
	$sql = "SELECT * FROM rezervari_cos WHERE uid = '".trim(UID)."' ORDER BY data_add ASC";
	$result = @mysqli_query($con,$sql); $total = @mysqli_num_rows($result);
	if($total >= 1){
		$html = '<div class="cartmini__widget">';
	}

	while ($row = mysqli_fetch_assoc($result)) 
	{
		$produs = $row['produs'];
		$link_url = $row['link_url'];
		$pretul = $row['pret_unit'];
		$buc = $row['buc'];
		$pret_item = $pretul * $buc;
		$imaginea = $row['produs_image'];
		$subtotal += $pret_item;

		$html.= '<div class="cartmini__widget-item"><div class="cartmini__thumb">';
		$html.= '<a href="'.$link_url.'"><img src="'.$imaginea.'" alt="PRODUS"></a></div>';
    $html.= '<div class="cartmini__content"><h5 class="cartmini__title">';
		$html.= '<a href="'.$link_url.'">'.$produs.'</a></h5>';
		$html.= '<div class="cartmini__price-wrapper">';
    $html.= '<span class="cartmini__price">'.$pretul.' LEI</span>';
    $html.= '<span class="cartmini__quantity"> x '.$buc.' buc</span>';
    $html.= '</div></div>';
    //$html.= '<a href="javascript:void(0);" class="cartmini__del ms-3"><i class="fa-regular fa-xmark"></i></a>';
    $html.= '</div>'."\n\n";
	}
	@mysqli_free_result($result);
	if($total >= 1){ 
		$html.= '</div>';	
	} else {
		$html = '<div class="cartmini__empty text-center">
		<p>Cosul Meu este Gol</p><a href="toate-produsele/" class="w-btn">Du-te la produse</a></div>';
	}

	$this->assign('ListaCosulMeu',$html);
	$this->assign('CosSubTotal', (int) $subtotal);
	$this->assign('CosTotalPlata',(int) ($subtotal+18));
}
/**************************************************************************************************/
}