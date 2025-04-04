{include "main/begin.tpl"}
{include "main/preloader.tpl"}
{include "main/header.tpl"}
{include "main/header_sticky.tpl"}

<main>
{$BREADCRUMB}




<section class="w-shop-area pb-120">
<div class="container">
   <div class="row">
      <div class="col-xl-12">
         <div class="w-shop-main-wrapper">
            
            <div class="w-shop-top mb-45">
               <div class="row">
                  <div class="col-xl-6">
                     <div class="w-shop-top-left d-flex align-items-center ">
                        {*include "parts/tabulare_catalog.tpl"*}
                        <div class="w-shop-top-result mt-2 text-center">
                           <p>Total <strong>{$TOTALS}</strong> produse</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-6 text-center text-lg-start">
                     {include "parts/sortare_catalog.tpl"}
                  </div>
               </div>
            </div>
            <div class="w-shop-items-wrapper w-shop-item-primary">
               <div class="tab-content" id="productTabContent">
                  <div class="tab-pane fade show active" id="grid-tab-pane" role="tabpanel" aria-labelledby="grid-tab" tabindex="0">
                     <div class="row">

                        {$LISTA_PRODUSE}

                     </div>
                  </div>

                  {*include "parts/mode_listare.tpl"*}

                </div>                            
            </div>

            {include "parts/paginare_catalog.tpl"}


         </div>
      </div>
   </div>
</div>
</section>



<!-- <section class="w-about-area pb-80 pt-25">
<div class="container"><div class="row">

  <div class="col-xl-12">
    <h3 class="text-center text-lg-start mb-3">{$HTML_ANTET}</h3>
    <div class="w-about-content">
        {$HTML_CONTEXT}
    </div>
  </div>

</div></div>
</section> -->

</main>

{include "main/footer.tpl"}
{include "main/end.tpl"}