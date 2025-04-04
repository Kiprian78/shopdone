{include "main/begin.tpl"}
{include "main/preloader.tpl"}
{include "main/header.tpl"}
{include "main/header_sticky.tpl"}

<main>
{$BREADCRUMB}

<section class="w-about-area pb-80 pt-25 testiPage">
<div class="container"><div class="row ">

{if ($showBlog<1)}

  <div class="row d-flex align-items-center">  
    <div class="col-12 text-center mb-2 mt-5">
      <div style="height: 300px !important;">
        <p>Nu am gasit articole postate in Blog !</p>
      </div>
    </div>
  </div>

  {else}
  <div class="row d-flex align-items-center">
  {/if}  
  
  {loop $art=$lstBlog}

  <div class="col-11 col-xl-4 col-lg-4 col-sm-6 mb-60 mx-auto">
   <div class="w-blog-item rounded">  
     <div class="w-blog-thumb p-relative fix">
        <a href="{$art.link_url}"><img src="{$art.imaginea}" class="img-fluid" alt="Detalii articol Blog"></a>
        <div class="w-blog-meta w-blog-meta-date"><span>{$art.date_pub}</span></div>
     </div>
     <div class="w-blog-content">
        <h3 class="w-blog-title"><a href="{$art.link_url}">{$art.art_title}</a></h3>
        <p>{$art.info}</p>
        <div class="w-blog-btn text-center text-lg-start">
           <a href="{$art.link_url}" class="w-btn-2 w-btn-border-2">{$art.read_more}
              <span><i class="fa-solid fa-arrow-right ms-2"></i></span>
           </a>
        </div>
     </div></div>
  </div>
  
  {/loop}


</div></div>
</section> 

</main>

{include "main/footer.tpl"}
{include "main/end.tpl"}