<?php
/***************************************************************/
$incTPL = 'trimite_comanda.tpl';
$selTM = $pag->getTM(9);
/***************************************************************/
$bc = new Breadcrumb('Trimite comanda');
$bc->addItem('Cosul Meu','cosul-meu/');
$bc->addItem('Finalizare');
$bc->getHTML();
/***************************************************************/
$showMesaj = 0; $postMesaj = "";
/***************************************************************/
if( h($_POST['numele']) !== '' && h($_POST['email']) !== '' && h($_POST['mod_plata']) !== '')
{
  $total_comanda  = 0;
  $taxa_transport = 18;
  $total_plata    = 0;  

  $numele_prenumele = h($_POST['numele']);
  $cod_fiscal = h($_POST['cod_fiscal']);
  $telefon = h($_POST['telefon']);
  $email = h($_POST['email']);
  $loc_judet = h($_POST['loc_judet']);
  $adresa_livrare = h($_POST['adresa_livrare']);
  $adresa_facturare = h($_POST['adresa_facturare']);
  $adresa_client  = h($_POST['adresa_facturare']);
  $observatii = h($_POST['observatii']);

  $sql = "INSERT INTO comenzi_produse SET ";
  $sql.= "com_data = NOW(), ";
  $sql.= "com_status = 'Noua', ";
  $sql.= "mod_plata = '".h($_POST['mod_plata'])."', ";
  $sql.= "numele_prenumele = '".$numele_prenumele."', ";
  $sql.= "cod_fiscal = '".$cod_fiscal."', ";
  $sql.= "telefon = '".$telefon."', ";
  $sql.= "email = '".$email."', ";
  $sql.= "loc_judet = '".$loc_judet."', ";
  $sql.= "adresa_livrare = '".$adresa_livrare."', ";
  $sql.= "adresa_facturare = '".$adresa_facturare."', ";
  $sql.= "adresa_client = '".$adresa_client."', ";
  $sql.= "observatii = '".$observatii."', ";
  $sql.= "taxa_transport = '".$taxa_transport."', ";
  $sql.= "add_edit = NOW();";
  @mysqli_query($con, $sql);
  $com_nr = @mysqli_insert_id($con);

if($com_nr >= 1 )
{
  $postMesaj = '<div class="col-12 text-center">
  <div class="bg-success text-white p-5 rounded">
  <h3 class="text-white">Comanda dvs a fost trimisa cu success !</h3>
  <p class="text-white">Va multumim.</p>
  </div></div>'."\n\n";  
  $showMesaj = 1;

  $sql = "SELECT * FROM rezervari_cos WHERE uid = '".trim(UID)."' ORDER BY data_add ASC";
  $result = @mysqli_query($con,$sql); $nivel = 0;
  while ($row = mysqli_fetch_assoc($result)) 
  {
    $nivel += 1;
    $pretul = $row["pret_unit"];
    $buc = $row["buc"];
    $subtotal = $row["pret_unit"] * $row["buc"];
    $total_comanda += $subtotal;

    $produs_link_url  = trim(WEB_BASE_URL).'produs/'.$row['id_produs'].'-'.Text2URL($row['produs']).'.html';
    $produs_image     = trim(WEB_BASE_URL).$row['produs_image'];

    $sql = "INSERT INTO comenzi_items SET ";
    $sql.= "com_nr = '".$com_nr ."', ";
    $sql.= "id_produs = '".$row["id_produs"]."', ";
    $sql.= "produs_name = '".h($row['produs'])."', ";
    $sql.= "produs_link_url = '".$produs_link_url."', ";
    $sql.= "produs_image = '".$produs_image."', ";
    $sql.= "cantitate = '".$row["buc"]."', ";
    $sql.= "pret_unit = '".$row["pret_unit"]."', ";
    $sql.= "pret_total = '".$subtotal."', ";
    $sql.= "nivel = '".$nivel."', ";
    $sql.= "add_edit  = NOW();";
    @mysqli_query($con,$sql);
  }
  @mysqli_free_result($result);
  $total_plata = $total_comanda + $taxa_transport;
/****************************************************************************/
  @mysqli_query($con,"UPDATE comenzi_produse SET total_comanda = '".$total_comanda."' , total_plata = '".$total_plata."' WHERE com_nr = '".$com_nr."';");
  @mysqli_query($con,"DELETE FROM rezervari_cos WHERE uid = '".trim(UID)."';");
  @mysqli_query($con,"OPTIMIZE TABLE rezervari_cos, comenzi_produse, comenzi_items;");
/****************************************************************************/
} else {
  $postMesaj = '<div class="col-12 text-center">
  <div class="bg-danger text-white p-5 rounded">
  <h3 class="text-white">NU s-a putut procesa comanda dvs !</h3>
  <p class="text-white">Posibil datele trimise sunt invalide.<br>Va rugam incercati din nou.</p>
  </div></div>'."\n\n";  
  $showMesaj = 1; 
}
/***************************************************************/
$pag->assign('showMesaj',$showMesaj);
$pag->assign('postMesaj',$postMesaj);


/***************************************************************/
} else {
/***************************************************************/
$subtotal = 0; $total_cos = 0;
/***************************************************************/
$lstCosulMeu = array(); $k = 0;
$sql = "SELECT * FROM rezervari_cos WHERE uid = '".trim(UID)."' ORDER BY data_add ASC";
$result = @mysqli_query($con,$sql);
while ($row = mysqli_fetch_assoc($result)) 
{
  $pretul = $row["pret_unit"];
  $buc = $row["buc"];
  $total = $row["pret_unit"] * $row["buc"];
  $lstCosulMeu[$k] = $row;
  $lstCosulMeu[$k]['nume_produs'] = wordwrap(trim($row['produs']),48,'<br>');  
  $subtotal += $total;

  $k++;
}
@mysqli_free_result($result);
/***************************************************************/
$pag->assign('SubTotal',$subtotal);
$pag->assign('TotalPlata',$subtotal+18);
/***************************************************************/
}