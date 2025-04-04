{include "main/begin.tpl"}
{include "main/preloader.tpl"}
{include "main/header.tpl"}
{include "main/header_sticky.tpl"}

<main>
{$BREADCRUMB}

<section class="w-about-area pb-80 pt-25 testiPage">
<div class="container"><div class="row ">

{if ($showPost>=1)}
   <div class="col-xl-12 col-lg-12 mx-auto text-center">
    <div class="w-contact-wrapper">

      <div class="card shadow border">
        <div class="card-body py-4">
            {$msgPost}
        </div>
      </div>

    </div>
  </div>

{else}
   <div class="col-xl-6 col-lg-6 mx-auto text-center">
    <div class="w-contact-wrapper">
    <h3 class="w-contact-title text-center">Recuperare date CONTUL MEU</h3>
    <form method="post" action="recovery/">
   
    <div class="row mb-2">
      <div class="col-xl-12 col-lg-12 mb-4">
        <div class="w-contact-input-box">
        <div class="w-contact-input">
          <input name="email" id="email" type="email" class="fw-bold" required minlength="5" placeholder="Adresa de E-mail ...">
        </div>
        <div class="w-contact-input-title">
          <label for="email" class="color3-tema">Adresa de E-mail</label>
        </div>
        </div>
      </div>  
      </div>   


    <div class="row mb-2">
    <div class="col-xl-12 col-lg-12 mb-3">  
      <div class="w-contact-btn w-100">
        <button type="submit" class="w-100">Recuperare date cont</button>
      </div>
    </div>
      <div class="col-xl-12 col-lg-12 mb-4">
        <div class="w-contact-text-box">
          <span>Inapoi la</span> &nbsp; &gt; &nbsp;<a href="login/"><strong>Autentificare in contul meu</strong></a>
        </div>
     </div>    
    </div>

    </form>
    </div>
   </div>

{/if}



</div></div>
</section> 

</main>

{include "main/footer.tpl"}
{include "main/end.tpl"}