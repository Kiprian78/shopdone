{include "main/begin.tpl"}
{include "main/preloader.tpl"}
{include "main/header.tpl"}
{include "main/header_sticky.tpl"}

<main>
{$BREADCRUMB}


<section class="w-cart-area pb-120">
<div class="container">
   <div class="row">

{if ($ShowCos<1)}

<div class="col-12 text-center pt-90 pb-90">
<h6>Nu aveti produse adaugate in cos.</h6>
<p class="mt-4"><a href="toate-produsele/" class="btn btn-outline-dark">Continuați cumpărăturile</a></p>
</div>


{else}   

<div class="col-xl-9 col-lg-8">
<div class="w-cart-list mb-25 mr-30">
<table class="table">
<thead>
<tr>
   <th colspan="2" class="w-cart-header-product">Denumirea produsele</th>
   <th class="w-cart-header-price">Pretul</th>
   <th class="w-cart-header-quantity">Cantitatea</th>
   <th></th>
</tr>
</thead>
<tbody>

{loop $item=$lstCosulMeu}

   <tr>                     
      <td class="w-cart-img"><a href="{$item.link_url}"><img src="{$item.produs_image}" class="rounded border" alt="DETALII"></a></td>                     
      <td class="w-cart-title"><a href="{$item.link_url}"><h6 class="ps-3" style="margin-top:-20px;">{$item.nume_produs}</h6></a></td>                     
      <td class="w-cart-price"><span><strong>{$item.pret_unit}</strong> Lei</span></td>
      
      <td class="w-cart-quantity">
         <div class="w-product-quantity mt-10 mb-10">
            <span class="w-cart-minus" onclick="javascript:CosMinus({$item.id_cart});">
               <svg width="10" height="2" viewBox="0 0 10 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>                                                             
            </span>
            <input class="w-cart-input" type="text" value="{$item.buc}">
            <span class="w-cart-plus" onclick="javascript:CosPlus({$item.id_cart});">
               <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5 1V9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M1 5H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>
            </span>
         </div>
      </td>
      
      <td class="w-cart-action">
         <button class="w-cart-action-btn" onclick="javascript:RemoveFromCos({$item.id_cart});">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M9.53033 1.53033C9.82322 1.23744 9.82322 0.762563 9.53033 0.46967C9.23744 0.176777 8.76256 0.176777 8.46967 0.46967L5 3.93934L1.53033 0.46967C1.23744 0.176777 0.762563 0.176777 0.46967 0.46967C0.176777 0.762563 0.176777 1.23744 0.46967 1.53033L3.93934 5L0.46967 8.46967C0.176777 8.76256 0.176777 9.23744 0.46967 9.53033C0.762563 9.82322 1.23744 9.82322 1.53033 9.53033L5 6.06066L8.46967 9.53033C8.76256 9.82322 9.23744 9.82322 9.53033 9.53033C9.82322 9.23744 9.82322 8.76256 9.53033 8.46967L6.06066 5L9.53033 1.53033Z" fill="currentColor"/>
            </svg>
            <span>Sterge</span>
         </button>
      </td>
   </tr>

{/loop}
            
</tbody>
</table>
</div>
</div>
      
{/if}         


{if ($ShowCos>0)}

<div class="col-xl-3 col-lg-4 col-md-6">
<div class="w-cart-checkout-wrapper">
   <div class="w-cart-checkout-top d-flex align-items-center justify-content-between">
      <span class="w-cart-checkout-top-title">SubTotal</span>
      <span class="w-cart-checkout-top-price text-dark">{$SubTotal} Lei</span>
   </div>
   <div class="w-cart-checkout-total d-flex align-items-center justify-content-between">
      <span>Transport curier</span>
      <span class="text-dark">+ 18 LEI</span>
   </div>   
   <div class="w-cart-checkout-shipping">
      <h4 class="w-cart-checkout-shipping-title">Modul de plata</h4>
      <div class="w-cart-checkout-shipping-option">
         <input id="online" type="radio" name="shipping" checked>
         <label for="online"><strong>Card Online (Stripe Pay)</strong></label>
      </div>
      <div class="w-cart-checkout-shipping-option-wrapper">
         <div class="w-cart-checkout-shipping-option">
            <input id="flat_rate" type="radio" name="shipping">
            <label for="flat_rate"><strong>OP Bancar</strong></label>
         </div>
         <div class="w-cart-checkout-shipping-option">
            <input id="local_pickup" type="radio" name="shipping">
            <label for="local_pickup"><strong>Ramburs (Curier)</strong></label>
         </div>
      </div>
   </div>
   <div class="w-cart-checkout-total d-flex align-items-center justify-content-between">
      <span>Total Comanda</span>
      <span><h5 class="text-danger">{$SubTotal} Lei</h5></span>
   </div>   
   <div class="w-cart-checkout-proceed">
      <a href="trimite-comanda/" class="w-cart-checkout-btn w-100">Finalizare comanda</a>
   </div>   
</div>
</div>

{/if}


</div></div>
</section>

</main>

{include "main/footer.tpl"}
{include "main/end.tpl"}