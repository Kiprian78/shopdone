{include "main/begin.tpl"}
{include "main/preloader.tpl"}
{include "main/header.tpl"}
{include "main/header_sticky.tpl"}

<main>
{$BREADCRUMB}

<section class="w-about-area pb-80 pt-25 testiPage">
<div class="container"><div class="row ">

{if ($showTest<1)}
  <div class="row d-flex align-items-center">
  
    <div class="col-12 text-center mb-2 mt-5">
      <div style="height: 300px !important;">
        <p>Nu am gasit rezultate.</p>
      </div>
    </div>
  
  {else}
  <div class="row masonry d-flex align-items-center">
  {/if}  
  
  {loop $itm=$lstTest}
  
    <div class="col-12 col-md-4 mItem mb-2">
     <div class="card h-100"><div class="card-body">     
        <p class="marturie">"{$itm.marturia}"</p>
        <div class="d-flex align-items-center">
          <div class="d-inline-block pe-3">
            <img class="rounded avatar" src="{$itm.imaginea}" alt="">
          </div>
          <div class="d-inline-block text-start">
            <h5>{$itm.autor}</h5>
            <div class="d-block text-warning mb-1">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            </div>
          </div>
        </div>
      </div></div>
    </div>
  
  {/loop}

</div></div>
</section> 

</main>

{include "main/footer.tpl"}
{include "main/end.tpl"}