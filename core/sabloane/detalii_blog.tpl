{include "main/begin.tpl"}
{include "main/preloader.tpl"}
{include "main/header.tpl"}
{include "main/header_sticky.tpl"}

<main>
{$BREADCRUMB}

<section class="w-postbox-details-area pb-120 pt-45">
<div class="container"><div class="row">
<div class="col-12">
     <div class="w-postbox-details-top">
     <h3 class="w-postbox-details-title text-center">{$xBlog.art_title}</h3>
     <div class="w-postbox-details-meta text-center mb-50">
        <span><i class="fa-solid fa-calendar me-2"></i>{$xBlog.data_pub}</span>
        <span><i class="fa-solid fa-eye me-2 ms-3"></i>{$xBlog.accesari} accesari</span>
     </div></div>
     <div class="w-postbox-details-thumb">
        <img src="{$xBlog.imaginea}" class="img-fluid border rounded" alt="">
     </div>        
    </div>
    
   </div>
   <div class="row">
      <div class="col-xl-9 col-lg-9">
         <div class="w-postbox-details-main-wrapper">
            <div class="w-postbox-details-content">
               {$xBlog.art_info}
               
               <br><hr>

               <div class="w-postbox-details-share-wrapper">
                  <div class="row">
                     <div class="col-12">
                        <div class="w-postbox-details-share text-center">
                           <span class="me-2">Urmariti-ne si online:</span>
                           {$xSM}
                        </div>
                     </div>
                  </div>
               </div>
              

            </div>
         </div>
      </div>
      <div class="col-xl-3 col-lg-3">
         <div class="w-sidebar-wrapper w-sidebar-ml--24">

{if ($showAlteBlog>0)}         
<div class="w-sidebar-widget mb-45">
<h3 class="w-sidebar-widget-title">Alte Noutati</h3>
<div class="w-sidebar-widget-content">
<div class="w-sidebar-blog-item-wrapper">

{loop $art=$alteBlog}

    <div class="w-sidebar-blog-item d-flex align-items-center">
      <div class="w-sidebar-blog-thumb"><a href="{$art.link_url}"><img src="{$art.imaginea}" alt="{$art.art_title}"></a></div>
      <div class="w-sidebar-blog-content"><div class="w-sidebar-blog-meta"><span>{$art.date_pub}</span></div>
      <h3 class="w-sidebar-blog-title"><a href="{$art.link_url}">{$art.art_title}</a></h3></div>
    </div>

{/loop}

</div></div>
</div>
{/if}

</div></div></div></div>
</section>


</main>
{include "main/footer.tpl"}
{include "main/end.tpl"}