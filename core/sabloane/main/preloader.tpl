
<div id="loading">
<div id="loading-center"><div id="loading-center-absolute"><div class="w-preloader-content">
<div class="w-preloader-logo">
<svg version="1.1" width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
<g id="loader"><animateTransform xlink:href="#loader"  attributeName="transform" attributeType="XML" type="rotate"
from="0 50 50" to="360 50 50" dur="0.9s" begin="0s"  repeatCount="indefinite"  restart="always"/>
  <path class="a" opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M50 100C77.6142 100 100 77.6142 100 50C100 22.3858 77.6142 0 50 0C22.3858 0 0 22.3858 0 50C0 77.6142 22.3858 100 50 100ZM50 90C72.0914 90 90 72.0914 90 50C90 27.9086 72.0914 10 50 10C27.9086 10 10 27.9086 10 50C10 72.0914 27.9086 90 50 90Z" fill="#ddd"/>
  <path class="b" fill-rule="evenodd" clip-rule="evenodd" d="M100 50C100 22.3858 77.6142 0 50 0V10C72.0914 10 90 27.9086 90 50H100Z" fill="#47883e"/>
</g></svg>
</div>
</div></div></div>  
</div>

<div class="back-to-top-wrapper">
<button id="back_to_top" type="button" class="back-to-top-btn">
   <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
   </svg>               
</button>
</div>


      <div class="offcanvas__area offcanvas__radius">
         <div class="offcanvas__wrapper">
            <div class="offcanvas__close">
               <button class="offcanvas__close-btn offcanvas-close-btn">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                 </svg>
               </button>
            </div>
            <div class="offcanvas__content">
               <div class="offcanvas__top mb-70 d-flex justify-content-between align-items-center">
                  <div class="offcanvas__logo logo">
                     <a href="./"><img src="assets/img/logo.svg" alt="Logo"></a>
                  </div>
               </div>
               <div class="offcanvas__category pb-40">
                  <button class="w-offcanvas-category-toggle">
                     <i class="fa-solid fa-bars"></i>
                     Toate categoriile
                  </button>
                  <div class="w-category-mobile-menu">
                     
                  </div>
               </div>
               <div class="w-main-menu-mobile fix d-lg-none mb-40"></div>

               <div class="ms-3">
                  <h4 class="w-contact-social-title">{$ws_config.ct_antet_3}</h4>
                  <div class="w-footer-social">{$xSM}</div>
               </div>

            </div>
         </div>

      </div>
      <div class="body-overlay"></div>

 

      <section class="w-search-area">
         <div class="container">
            <div class="row">
               <div class="col-xl-12">
                  <div class="w-search-form">
                     <div class="w-search-close text-center mb-20">
                        <button class="w-search-close-btn w-search-close-btn"></button>
                     </div>
                     <form method="get" action="cautare/">
                        <div class="w-search-input mb-10">
                           <input id="caut" name="caut" type="text" placeholder="Cauta in produse ...">
                           <button type="submit"><i class="flaticon-search-1"></i></button>
                        </div>
                        <div class="w-search-category">
                           <span>Intoduceti textul pentru cautare</span>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </section>


      
      <div class="cartmini__area w-all-font-roboto">
         <div class="cartmini__wrapper d-flex justify-content-between flex-column">
             <div class="cartmini__top-wrapper">
                 <div class="cartmini__top p-relative">
                     <div class="cartmini__top-title">
                         <h4>Cosul Meu</h4>
                     </div>
                     <div class="cartmini__close">
                         <button type="button" class="cartmini__close-btn cartmini-close-btn"><i class="fal fa-times"></i></button>
                     </div>
                 </div>                               
                 {$ListaCosulMeu}                                
             </div>

{if ($TotalCosulMeu>0)}              

             <div class="cartmini__checkout">             
                  <div class="cartmini__checkout-title mb-2">
                     <h4>Sub-Total:</h4>
                     <span>{$CosSubTotal} LEI</span>
                  </div>  
                  <div class="cartmini__checkout-title mb-2">
                     <h4>Transport:</h4>
                     <span>18 LEI</span>
                  </div>                              
                 <div class="cartmini__checkout-title mb-50">
                     <h4>Total de plata:</h4>
                     <span>{$CosTotalPlata} LEI</span>
                 </div>
                 <div class="cartmini__checkout-btn">
                     <a href="cosul-meu/" class="w-btn mb-10 w-100">Vezi cosul meu</a>
                     <a href="trimite-comanda/" class="w-btn w-btn-border w-100">Finalizare</a>
                 </div>
             </div>

{/if}

</div>
</div>

     