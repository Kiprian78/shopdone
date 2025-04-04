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
              <a class="nav-link active" href="contul-meu/comenzi/"><span><i class="fa-regular fa-rectangle-list"></i></span> Comenzile Mele</a>
              <a class="nav-link" href="contul-meu/favorite/"><span><i class="fa-regular fa-heart"></i></span> Produse Favorite</a>
              <a class="nav-link" href="contul-meu/securitate/"><span><i class="fa-regular fa-lock"></i></span> Modificare Parola</a>
              <a class="nav-link" href="logout/"><span><i class="fa-regular fa-right-from-bracket"></i></span> LogOut</a>

              <span id="marker-vertical" class="w-tab-line d-none d-sm-inline-block"></span>
            </div>
        </nav>
      </div>
  </div>



<div class="col-xxl-8 col-lg-8">

   <div class="profile__tab-content">
      <div class="tab-content" id="profile-tabContent">

         <div class="tab-pane fade show active" id="nav-order" role="tabpanel" aria-labelledby="nav-order-tab">
           <h3 class="profile__info-title">Comenzile Mele</h3>
            <div class="profile__ticket table-responsive">
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">Nr.Com</th>      
                        <th scope="col">Data.Com</th>                  
                        <th scope="col">Status</th>
                        <th scope="col">Total</th>
                        <th scope="col">Vezi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <th scope="row">#323</th>
                        <td data-info="title">22.12.2024</td>
                        <td data-info="status pending">Pending</td>
                        <td data-info="price"><strong>254 lei</strong></td>
                        <td><a href="#" class="w-logout-btn">Detalii</a></td>
                     </tr>
                     <tr>
                        <th scope="row">#323</th>
                        <td data-info="title">22.12.2024</td>
                        <td data-info="status pending">Pending</td>
                        <td data-info="price"><strong>254 lei</strong></td>
                        <td><a href="#" class="w-logout-btn">Detalii</a></td>
                     </tr>
                     <tr>
                        <th scope="row">#323</th>
                        <td data-info="title">22.12.2024</td>
                        <td data-info="status pending">Pending</td>
                        <td data-info="price"><strong>254 lei</strong></td>
                        <td><a href="#" class="w-logout-btn">Detalii</a></td>
                     </tr>
                     <tr>
                        <th scope="row">#323</th>
                        <td data-info="title">22.12.2024</td>
                        <td data-info="status pending">Pending</td>
                        <td data-info="price"><strong>254 lei</strong></td>
                        <td><a href="#" class="w-logout-btn">Detalii</a></td>
                     </tr>
                  </tbody>
               </table>
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