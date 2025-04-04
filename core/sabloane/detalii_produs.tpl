{include "main/begin.tpl"}
{include "main/preloader.tpl"}
{include "main/header.tpl"}
{include "main/header_sticky.tpl"}

<main>
{$BREADCRUMB}

<section class="w-product-details-area">
<div class="w-product-details-top pb-115">
<div class="container">
<div class="row">

         <div class="col-xl-7 col-lg-6">
            <div class="w-product-details-thumb-wrapper w-tab d-sm-flex">
               <nav>
                  <div class="nav nav-tabs flex-sm-column " id="productDetailsNavThumb" role="tablist">
                      {$btnPoze}
                  </div>
               </nav>
               <div class="tab-content m-img" id="productDetailsNavContent">
                  {$listaPoze}
                </div>
            </div>
         </div> 
         

         <div class="col-xl-5 col-lg-6">
            <div class="w-product-details-wrapper">
               <!-- <div class="w-product-details-category">
                  <span>Categoria aici</span>
               </div> -->
               <h3 class="w-product-details-title mb-20"><strong>{$xProdus.produsul}</strong></h3>
               <div class="w-product-details-inventory d-flex align-items-center mb-10">
                  <div class="w-product-details-stock mb-10">
                     <span>1 bucata</span>
                  </div>
                  <div class="w-product-details-rating-wrapper d-flex align-items-center mb-10">
                     <div class="w-product-details-rating">
                        <span><i class="fa-solid fa-star"></i></span>
                        <span><i class="fa-solid fa-star"></i></span>
                        <span><i class="fa-solid fa-star"></i></span>
                        <span><i class="fa-solid fa-star"></i></span>
                        <span><i class="fa-solid fa-star"></i></span>
                     </div>
                     <div class="w-product-details-reviews">
                        <span>( 2 Reviews )</span>
                     </div>
                  </div>                  
               </div>  

               <div class="w-product-details-price-wrapper mb-20">
                  {$preturi}
               </div>
             
               <div class="mb-4" style="font-size: 16px; font-wight: 600 !important;">
               <p>{$xProdus.intro}</p>
               </div>

               <div class="w-product-details-action-wrapper">                  
                  <button class="w-product-details-buy-now-btn" onclick="javascript:Add2Cos({$xProdus.id_produs});"><i class="fa fa-basket me-2"></i>ADAUGA IN COS</button>
                  <button class="w-product-details-favorite-btn" onclick="javascript:Add2Fav({$xProdus.id_produs});"><i class="fa fa-heart me-2"></i> FAVORITE</button>
               </div>

               <div class="w-product-details-msg mb-25">
                  <ul>
                     <li>30 zile garantie</li>
                     <li>Beneficiati de un cadou</li>
                  </ul>
               </div>

               <!-- <div class="w-product-details-query">
                  <div class="w-product-details-query-item d-flex align-items-center">
                     <span>SKU:  </span>
                     <p>JHJKLJKJ434</p>
                  </div>
                  <div class="w-product-details-query-item d-flex align-items-center">
                     <span>Categoria:  </span>
                     <p>Nume categorie</p>
                  </div>
                  <div class="w-product-details-query-item d-flex align-items-center">
                     <span>Tag: </span>
                     <p>Cuvinte cheie tags</p>
                  </div>
               </div> -->

               <hr>
               <div class="w-product-details-social">
                  <span>Urmariti-ne si online: </span><br>
                  {$xSM}
               </div>

            </div>
         </div>
      </div>
   </div>
</div>
<div class="w-product-details-bottom pb-140">
<div class="container"><div class="row"><div class="col-xl-12">
            
<div class="w-product-details-tab-nav w-tab">
<nav>
<div class="nav nav-tabs justify-content-center p-relative w-product-tab" id="navPresentationTab" role="tablist">
<button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab" data-bs-target="#nav-description" type="button" role="tab" aria-controls="nav-description" aria-selected="true">Descriere produs</button>                    
<button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review" aria-selected="false">Reviews (2)</button>
<span id="productTabMarker" class="w-product-details-tab-line"></span>
</div>
</nav>  

<div class="tab-content" id="navPresentationTabContent">
<div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab" tabindex="0">
<div class="w-product-details-desc-wrapper pt-50">
   <div class="row justify-content-center">
      <div class="col-xl-10">
         <div class="w-product-details-desc-item pb-3">
            <div class="row display-3">
            {$xProdus.info}
            </div>
         </div>
      </div>
   </div>
</div>
</div>

<div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab" tabindex="0">
<div class="w-product-details-review-wrapper pt-60"><div class="row">

{include "parts/produs_reviews.tpl"}

</div></div></div></div>                                                
</div></div></div></div></div>
</section>



{if ($ShowAltele>0)}
<!-- BEGIN ALTE PRODUSE SIMILARE  -->
<section class="w-related-product pt-95 pb-120">
<div class="container"><div class="row">
<div class="w-section-title-wrapper-6 text-center mb-40">
<h3 class="w-section-title-4">Produse similare</h3>
</div></div><div class="row">
<div class="w-product-related-slider">
<div class="w-product-related-slider-active swiper-container  mb-10">
<div class="swiper-wrapper">
               
{$ALTE_PRODUSE}

</div></div><div class="w-related-swiper-scrollbar w-swiper-scrollbar"></div>
</div></div></div>
</section>
<!-- END ALTE PRODUSE SIMILARE  -->
{/if}

</main>
{include "main/footer.tpl"}
{include "main/end.tpl"}