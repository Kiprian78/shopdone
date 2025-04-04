{include "main/begin.tpl"}
{include "main/preloader.tpl"}
{include "main/header.tpl"}
{include "main/header_sticky.tpl"}

<main>
{$BREADCRUMB}

<section class="w-about-area pb-80 pt-25">
<div class="container"><div class="row">

  <div class="col-xl-12">
    <h3 class="text-center text-lg-start mb-3">{$HTML_ANTET}</h3>
    <div class="w-about-content">
        {$HTML_CONTEXT}
    </div>
  </div>

</div></div>
</section> 

</main>

{include "main/footer.tpl"}
{include "main/end.tpl"}