
{if ($showFeatures>0)}
<section class="w-feature-area w-feature-border-radius pb-70">
<div class="container"><div class="row gx-1 gy-1 gy-xl-0">

   {loop $box=$boxFeatures}
         <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="w-feature-item d-flex align-items-start rounded">
               <div class="w-feature-icon mr-15">
                  <span><i class="{$box.icoana}"></i></span>
               </div>
               <div class="w-feature-content">
                  <h3 class="w-feature-title">{$box.titlul}</h3>
                  <p>{$box.info}</p>
               </div>
            </div>
         </div> 
   {/loop}

</div></div>
</section>
{/if}
