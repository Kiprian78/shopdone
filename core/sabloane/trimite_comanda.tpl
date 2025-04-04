{include "main/begin.tpl"}
{include "main/preloader.tpl"}
{include "main/header.tpl"}
{include "main/header_sticky.tpl"}

<main>
{$BREADCRUMB}

<section class="w-cart-area pb-120">
<div class="container">
<div class="row">

{if ($showMesaj>0)}

{$postMesaj}

<script>
function Go2CosPage(){ window.location.href='cosul-meu/'; }
setTimeout(Go2CosPage,9000);
</script>



{else}

   <div class="col-xl-9 col-lg-8 order-lg-0 order-1">
    <div class="w-contact-wrapper">
    <h3 class="w-contact-title text-center text-lg-start">Formularul de comanda</h3>
    <form method="post" action="trimite-comanda/">
   
    <div class="row mb-2">
      <div class="col-xl-8 col-lg-8 mb-4">
        <div class="w-contact-input-box">
        <div class="w-contact-input">
          <input name="numele" id="numele" type="text" class="fw-bold" required minlength="5" placeholder="Numele si Prenumele ...">
        </div>
        <div class="w-contact-input-title">
          <label for="numele" class="color3-tema">Numele si Prenumele</label>
        </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 mb-4">
        <div class="w-contact-input-box">
        <div class="w-contact-input">
          <input name="cod_fiscal" id="cod_fiscal" type="text" class="fw-bold" required minlength="5" placeholder="Codul Fiscal / CNP ...">
        </div>
        <div class="w-contact-input-title">
          <label for="cod_fiscal" class="color3-tema">Codul Fiscal / CNP</label>
        </div>
        </div>
      </div>
    </div>

    <div class="row mb-2">
      <div class="col-xl-5 col-lg-5 mb-4">
        <div class="w-contact-input-box">
        <div class="w-contact-input">
          <input name="email" id="email" type="email" class="fw-bold" required minlength="5" placeholder="Adresa de E-mail ...">
        </div>
        <div class="w-contact-input-title">
          <label for="email" class="color3-tema">Adresa de E-mail</label>
        </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 mb-4">
        <div class="w-contact-input-box">
        <div class="w-contact-input">
          <input name="telefon" id="telefon" type="text" class="fw-bold" required minlength="5" placeholder="Nr.Telefon ...">
        </div>
        <div class="w-contact-input-title">
          <label for="telefon" class="color3-tema">Nr. de Telefon</label>
        </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 mb-4">
        <div class="w-contact-input-box">
        <div class="w-contact-input">
          <input name="loc_judet" id="loc_judet" type="text" class="fw-bold" required minlength="5" placeholder="Localitate / Judet ...">
        </div>
        <div class="w-contact-input-title">
          <label for="loc_judet" class="color3-tema">Localitate / Judet</label>
        </div>
        </div>
      </div>      
    </div>


    <div class="row mb-2">
      <div class="col-xl-12 col-lg-12 mb-4">
        <div class="w-contact-input-box">
        <div class="w-contact-input">
          <input name="adresa_livrare" id="adresa_livrare" type="text" class="fw-bold" required minlength="5" placeholder="Adresa de Livrare ...">
        </div>
        <div class="w-contact-input-title">
          <label for="adresa_livrare" class="color3-tema">Adresa de Livrare</label>
        </div>
        </div>
      </div>
    </div>

    <div class="row mb-2">
      <div class="col-xl-8 col-lg-8 mb-4">
        <div class="w-contact-input-box">
        <div class="w-contact-input">
          <input name="adresa_facturare" id="adresa_facturare" type="text" class="fw-bold" required minlength="6" placeholder="Adresa de Facturare ...">
        </div>
        <div class="w-contact-input-title">
          <label for="adresa_facturare" class="color3-tema">Adresa de Facturare</label>
        </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 mb-4">
        <div class="w-contact-input-box">
        <div class="w-contact-input">
          <select name="mod_plata" id="mod_plata" class="nice-select py-3 w-100 fw-bold" required  style="height: 55px;">
            <option value="RAMBURS">RAMBURS</option>
            <option value="OP_BANCA">OP BANCA</option>
          </select>
        </div>
        <div class="w-contact-input-title">
          <label for="mod_plata" class="color3-tema">Modul de plata</label>
        </div>
        </div>
      </div>      
    </div>

    <div class="row mb-2">
      <div class="col-xl-12 col-lg-12 mb-4">
        <div class="w-contact-input-box">
        <div class="w-contact-input">
          <textarea name="observatii" id="observatii" class="fw-bold" placeholder="Observatii comanda ..."></textarea>
        </div>
        <div class="w-contact-input-title">
          <label for="observatii" class="color3-tema">Observatii comanda (optional)</label>
        </div>
        </div>
      </div>
    </div>

    <div class="row mb-2">
    <div class="col-xl-8 col-lg-8 mb-3">
      <div class="w-contact-suggetions mb-20">
        <div class="w-contact-remeber">
          <input id="agree" type="checkbox" value="1" required>
          <label for="agree">{$ws_config.ct_agree_info}</label>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-4 mb-3">  
      <div class="w-contact-btn w-100">
        <button type="submit" class="w-100">Trimite Comanda</button>
      </div>
    </div>
    </div>

    </form>
    </div>
   </div>

   <div class="col-xl-3 col-lg-4 order-lg-1 order-0 mb-60">
   <h3 class="w-contact-title text-center text-lg-start">Sumar Comanda</h3>
   
    <div class="w-cart-checkout-wrapper">
      <div class="w-cart-checkout-top d-flex align-items-center justify-content-between">
          <span class="w-cart-checkout-top-title">SubTotal</span>
          <span class="w-cart-checkout-top-price text-dark">{$SubTotal} Lei</span>
      </div>
      <div class="w-cart-checkout-total d-flex align-items-center justify-content-between">
          <span>Transport curier</span>
          <span class="text-dark">+ 18 LEI</span>
      </div>   
      <div class="w-cart-checkout-total d-flex align-items-center justify-content-between">
          <span>Total Comanda</span>
          <span><h5 class="text-danger">{$TotalPlata} Lei</h5></span>
      </div>  
    </div>

   </div>

{/if}

</div></div>
</section>

</main>

{include "main/footer.tpl"}
{include "main/end.tpl"}