
{if ($showBlog>0)}
<section class="w-blog-area pt-50 pb-75">
<div class="container">
   <div class="row align-items-end">
      <div class="col-xl-4 col-md-6">
         <div class="w-section-title-wrapper mb-30">
            <h3 class="w-section-title">Ultimele noutăți</h3>
         </div>
      </div>
      <div class="col-xl-8 col-md-6">
         <div class="w-blog-more-wrapper d-flex justify-content-md-end">
            <div class="w-blog-more mb-30 text-md-end">
               <a href="noutati/" class="w-btn w-btn-2 w-btn-blue">Vezi toate noutățile 
                  <i class="fa-solid fa-arrow-right ms-2"></i>
               </a>
            </div>
         </div>
      </div>
   </div>
<div class="row">
<div class="col-xl-12">
<div class="w-blog-main-slider">
<div class="w-blog-main-slider-active swiper-container">
<div class="swiper-wrapper">

{loop $blog=$hpBlog}

<div class="w-blog-item mb-30 swiper-slide">
   <div class="w-blog-thumb p-relative fix">
      <a href="{$blog.link_url}"><img src="{$blog.imaginea}" alt="Detalii Blog"></a>
      <div class="w-blog-meta w-blog-meta-date"><span>{$blog.date_pub}</span></div>
   </div>
   <div class="w-blog-content">
      <h3 class="w-blog-title"><a href="{$blog.link_url}">{$blog.art_title}</a></h3>
      <p>{$blog.info}</p>
      <div class="w-blog-btn">
         <a href="{$blog.link_url}" class="w-btn-2 w-btn-border-2">{$blog.read_more}
            <span><i class="fa-solid fa-arrow-right ms-2"></i></span>
         </a>
      </div>
   </div>
</div>

{/loop}
      



</div></div></div>
</div></div>
</div>
</section>

{/if}

