<?php
/*****************************************************************************/
if(h($_POST['ctToken']) !== "" && h($_POST['email']) !== "")
{  
  $subiect = "CONTACT - ".trim(WEB_NAME);
  $mesajul = ''; $msg = '';

	$aip = h($_SERVER['REMOTE_ADDR']);
  $user_agent = h($_SERVER['HTTP_USER_AGENT']);

	$numele  = h($_POST['numele']); 
  $email = h($_POST['email']); 
  $telefon = h($_POST['telefon']);    
  $comentarii = h($_POST['comentarii']);  
  $agree = (h($_POST['agree']) >= 1 ? 'Da' : 'Nu');

  $msg.= '<!doctype html><html lang="ro"><head><meta charset="utf-8">'.
  '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">'.
  '<link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" '.
  'integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">'.
  '<title>CONTACT</title></head><body style="font-family:\'Open Sans\',sans-serif; background-color: #eee;color: #111;">'.
  '<div class="container mt-5"><div class="row mt-5"><div class="col-11 col-lg-8 mx-auto">'.
  '<div class="card border rounded shadow"><div class="card-body p-5 text-center">'."\n";


  if (!CSRF::verify(h($_POST['ctToken'])))
  {
    CSRF::regenToken();
    $msg.= '<h2 class="text-danger fw-bold text-center">Nu s-a trimis mesajul dvs pentru contact!</h2>'.
    '<h4 class="text-center text-danger fw-bold mt-3">Problema cu datele completate de dvs in formular.</h4>'."\n";		
 } 
 else 
 {

  $sablon_email = '<html><head><title>{#SUBIECT#}</title><style type="text/css" data-inline="true">
body { font-size:16px;font-family:\'Open Sans\',sans-serif; } h1, h2, h3, h4 { color: #111; padding: 10px 0px 3px 0px; }
a { text-decoration: none !important; transition: all 0.5s ease-in-out; } 
a:hover { text-decoration: underline !important; transition: all 0.25s ease-in-out; } 
</style></head><body bgcolor="#fff" style="padding:15px; margin:10px auto;font-size:16px;font-family:\'Open Sans\', sans-serif;">
<h4>Buna ziua,</h4>
<p style="font-size:16px;">Astăzi la <b>{#DATA_ORA#}</b> s-a trimis mesajul din sectiunea de <b>CONTACT</b>,  
urmatorul mesaj de contact:</p><br>  
<table width="100%" style="border:solid 2px #111;">        
<tr style="background-color: #ffffff;"><td width="15%" nowrap style="padding:10px;">Numele Prenumele:</td>
<td style="font-weight: bold;">{#NUMELE#}</td></tr>
<tr style="background-color: #f3f3f3;"><td width="15%" nowrap style="padding:10px;">Nr.Telefon:</td>
<td style="font-weight: bold;">{#TELEFON#}</td></tr>     
<tr style="background-color: #ffffff;"><td width="15%" nowrap style="padding:10px;">Adresa E-mail:</td>
<td style="font-weight: bold;">{#EMAIL#}</td></tr>
<tr style="background-color: #f3f3f3;"><td width="15%" nowrap style="padding:10px;">Acord GDPR:</td>
<td style="font-weight: bold;">{#ACORDUL#}</td></tr>               
<tr style="background-color: #ffffff;"><td colspan="2" style="padding:10px;">Comentarii:</td></tr>
<tr><td colspan="2" style="background-color: #ffffff; font-weight: bold;padding:5px 10px 25px 5px;">{#COMENTARII#}</td></tr>
</table><br><br><p>Va multumim !</p>
<h4 style="padding:0px;">Echipa {#APP_NAME#}</h4>
<hr style="border-color: #ccc;" noshade><p><small>Detalii Expeditor: <b>{#USER_INFO#}</b><br>
Adresa IP Expeditor: <b>{#ADRESA_IP#}</b></small></p></body></html>';

  $mesajul = trim($sablon_email);

  $mesajul   = str_replace('{#APP_NAME#}',trim(WEB_NAME),$mesajul);
  $mesajul   = str_replace('{#SUBIECT#}',$subiect,$mesajul);
  $mesajul   = str_replace('{#DATA_ORA#}',date("d.m.Y H:i"),$mesajul);

  $mesajul   = str_replace('{#NUMELE#}',$numele,$mesajul);
  $mesajul   = str_replace('{#EMAIL#}',$email,$mesajul);  
  $mesajul   = str_replace('{#TELEFON#}',$telefon,$mesajul);
  $mesajul   = str_replace('{#ACORDUL#}',$agree,$mesajul);
  $mesajul   = str_replace('{#COMENTARII#}', nl2br($comentarii),$mesajul);

  $mesajul   = str_replace('{#USER_INFO#}',$user_agent,$mesajul);      
  $mesajul   = str_replace('{#ADRESA_IP#}',$aip,$mesajul);

  $headers  = "From: ".trim(EMAIL_FROM)."\r\n";
  $headers .= "Reply-To: ".trim(EMAIL_OFFICE)."\r\n";
  $headers .= "CC: ".trim(EMAIL_SUPPORT)."\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

  @mail(trim(EMAIL_OFFICE),$subiect,$mesajul,$headers);
  //@mail(trim(EMAIL_SUPPORT),$subiect,$mesajul,$headers);

  $msg.= '<h2 class="text-success fw-bold">Mesajul dvs de contact a fost trimis.</h2>
  <h4 class="text-center fw-bold">Va multumim!</h4>';

 }

  $msg.= '</div></div></div></div></div>'.
  '<script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" '.
  'integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" '.
  'crossorigin="anonymous"></script></body></html>'."\n";

  echo $msg;

  CSRF::regenToken();
  @goRedirect('./',6);
  die("");
}
/*****************************************************************************/
$incTPL = 'contact.tpl';
$selTM = $pag->getTM(6);
/*****************************************************************************/
$bc = new Breadcrumb('Contact');
$bc->addItem('Contact');
$bc->getHTML();
/*****************************************************************************/