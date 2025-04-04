{include "main/begin.tpl"}
{include "main/preloader.tpl"}
{include "main/header.tpl"}
{include "main/header_sticky.tpl"}

<main>
{$BREADCRUMB}

<section class="w-about-area pb-80 pt-25 testiPage">
<div class="container"><div class="row ">

  <div class="col-xxl-4 col-lg-4">
      <div class="profile__tab mr-40">
        <nav>
            <div class="nav nav-tabs w-tab-menu flex-column" id="profile-tab" role="tablist">
              <a class="nav-link" href="contul-meu/"><span><i class="fa-regular fa-id-card"></i></span> Contul Meu</a>
              <a class="nav-link" href="contul-meu/informatii/"><span><i class="fa-regular fa-user-pen"></i></span> Date personale</a>
              <a class="nav-link" href="contul-meu/comenzi/"><span><i class="fa-regular fa-rectangle-list"></i></span> Comenzile Mele</a>
              <a class="nav-link" href="contul-meu/favorite/"><span><i class="fa-regular fa-heart"></i></span> Produse Favorite</a>
              <a class="nav-link active" href="contul-meu/securitate/"><span><i class="fa-regular fa-lock"></i></span> Modificare Parola</a>
              <a class="nav-link" href="logout/"><span><i class="fa-regular fa-right-from-bracket"></i></span> LogOut</a>

              <span id="marker-vertical" class="w-tab-line d-none d-sm-inline-block"></span>
            </div>
        </nav>
      </div>
  </div>



<div class="col-xxl-8 col-lg-8">

   <div class="profile__tab-content">
      <div class="tab-content" id="profile-tabContent">

         <div class="tab-pane fade show active" id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab">
            <h3 class="profile__info-title">Modificare parola</h3>
            <div class="profile__password">
               <form method="post" action="contul-meu/securitate/">
                  <div class="row">
                     <div class="col-xxl-12">
                        <div class="w-profile-input-box">
                           <div class="w-contact-input">
                              <input name="old_pass" id="old_pass" type="password" required minLen="5" placeholder="minmim 5 caractere ...">
                           </div>
                           <div class="w-profile-input-title">
                              <label for="old_pass">Vechea Parola</label>
                           </div>
                        </div>
                     </div>
                     <div class="col-xxl-6 col-md-6">
                        <div class="w-profile-input-box">
                           <div class="w-profile-input">
                              <input name="new_pass" id="new_pass" type="password" required minLen="5" placeholder="minmim 5 caractere ...">
                           </div>
                           <div class="w-profile-input-title">
                              <label for="new_pass">Parola Noua</label>
                           </div>
                        </div>
                     </div>
                     <div class="col-xxl-6 col-md-6">
                        <div class="w-profile-input-box">
                           <div class="w-profile-input">
                              <input name="con_new_pass" id="con_new_pass" type="password" required minLen="5" placeholder="minmim 5 caractere ...">
                           </div>
                           <div class="w-profile-input-title">
                              <label for="con_new_pass">Confirmare Parola</label>
                           </div>
                        </div>
                     </div>
                     <div class="col-xxl-6 col-md-6">
                        <div class="profile__btn">
                           <button type="submit" class="w-btn">Salvare modificari</button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>

      </div>
   </div>
</div>




</div></div>
</section> 

</main>

{include "main/footer.tpl"}
{include "main/end.tpl"}