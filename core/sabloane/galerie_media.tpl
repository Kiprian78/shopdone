{include "main/begin.tpl"}
{include "main/preloader.tpl"}
{include "main/header.tpl"}
{include "main/header_sticky.tpl"}

<main>
{$BREADCRUMB}

<section class="w-about-area pb-80 pt-25">
<div class="container"><div class="row">

{loop $foto=$lstFotos}
  <div class="col-6 col-lg-2 mb-4">
   <a href="{$foto.imaginea}" class="popup-image" title="{$foto.info}"><img src="{$foto.imaginea}" class="img-fluid rounded border" alt="" /></a>
   <div class="text-center">
     <small>{$foto.info}</small>
   </div>
  </div>
{/loop}

<br><br><br><br>

{loop $video=$lstVideo}
  <div class="col-12 col-lg-6 mb-4">  
   <iframe src="{$video.code_embed}" title="Video" class="w-100 rounded" style="min-height: 380px;" allowfullscreen></iframe>
   <div class="text-center">
     <small>{$video.info}</small>
   </div>
  </div>
{/loop}


</div></div>
</section> 

</main>

{include "main/footer.tpl"}
{include "main/end.tpl"}