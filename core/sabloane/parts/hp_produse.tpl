<section class="w-product-area pb-55">
   <div class="container">
      <div class="row align-items-end">

         <div class="col-xl-5 col-lg-6 col-md-5 text-center text-lg-start">
            <div class="w-section-title-wrapper mb-40">
               <h3 class="w-section-title">Produse</h3>
            </div>
         </div>

         <div class="col-xl-7 col-lg-6 col-md-7">
            <div
               class="w-product-tab w-product-tab-border mb-45 w-tab d-flex justify-content-md-end justify-content-center">
               <ul class="nav nav-tabs justify-content-center justify-content-sm-end" id="productTab" role="tablist">

                  <li class="nav-item" role="presentation">
                     <button class="nav-link active" id="new-tab" data-bs-toggle="tab" data-bs-target="#new-tab-pane"
                        type="button" role="tab" aria-controls="new-tab-pane" aria-selected="true">Noi</button>
                  </li>

                  <li class="nav-item" role="presentation">
                     <button class="nav-link" id="promo-tab" data-bs-toggle="tab" data-bs-target="#promo-tab-pane"
                        type="button" role="tab" aria-controls="promo-tab-pane"
                        aria-selected="false">Promoționale</button>
                  </li>

                  <li class="nav-item" role="presentation">
                     <button class="nav-link" id="topsell-tab" data-bs-toggle="tab" data-bs-target="#topsell-tab-pane"
                        type="button" role="tab" aria-controls="topsell-tab-pane"
                        aria-selected="false">Top Vănzări</button>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xl-12">
            <div class="w-product-tab-content">
               <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="new-tab-pane" role="tabpanel" aria-labelledby="new-tab"
                     tabindex="0">
                     <div class="row">

                        {$PRODUSE_NOI}

                     </div>
                  </div>
                  <div class="tab-pane fade" id="promo-tab-pane" role="tabpanel" aria-labelledby="promo-tab" tabindex="0">
                     <div class="row">

                        {$PRODUSE_PROMO}

                     </div>
                  </div>
                  <div class="tab-pane fade" id="topsell-tab-pane" role="tabpanel" aria-labelledby="topsell-tab"
                     tabindex="0">
                     <div class="row">

                        {$PRODUSE_TOPSELL}

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

   </div>
</section>