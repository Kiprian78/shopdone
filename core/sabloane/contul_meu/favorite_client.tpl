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
              <a class="nav-link active" href="contul-meu/favorite/"><span><i class="fa-regular fa-heart"></i></span> Produse Favorite</a>
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
            <h3 class="profile__info-title">Produse Favorite</h3>
            <div class="profile__ticket table-responsive">
               <table class="table">
                  <thead>
                     <tr>
                        <th width="15%" scope="col">Image</th>
                        <th scope="col">Denumire produs</th>
                        <th width="15%" scope="col">Pret</th>
                        <th width="25%" scope="col">Optiuni</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <th scope="row"><a href="#"><img src="uploads/produse/1717679680_1397613.webp" alt="Produs x denumirea" width="90" /></a></th>
                        <td data-info="title"><a href="#"><strong>Produs x denumirea</strong></a></td>
                        <td data-info="price"><strong>145 lei</strong></td>
                        <td><a href="#" class="w-logout-btn" title="ADAUGA IN COS"><i class="fa-solid fa-basket-shopping"></i></a>
                        <a href="#" class="w-logout-btn ms-2" title="STERGE"><i class="fa-regular fa-trash-can"></i></a></td>
                     </tr>
 
                     <tr>
                        <th scope="row"><a href="#"><img src="uploads/produse/1717685235_6784588.webp" alt="Produs x denumirea" width="90" /></a></th>
                        <td data-info="title"><a href="#"><strong>Produs x denumirea</strong></a></td>
                        <td data-info="price"><strong>145 lei</strong></td>
                        <td><a href="#" class="w-logout-btn" title="ADAUGA IN COS"><i class="fa-solid fa-basket-shopping"></i></a>
                        <a href="#" class="w-logout-btn ms-2" title="STERGE"><i class="fa-regular fa-trash-can"></i></a></td>
                     </tr>

                     <tr>
                        <th scope="row"><a href="#"><img src="uploads/produse/1717685903_2627096.webp" alt="Produs x denumirea" width="90" /></a></th>
                        <td data-info="title"><a href="#"><strong>Produs x denumirea</strong></a></td>
                        <td data-info="price"><strong>145 lei</strong></td>
                        <td><a href="#" class="w-logout-btn" title="ADAUGA IN COS"><i class="fa-solid fa-basket-shopping"></i></a>
                        <a href="#" class="w-logout-btn ms-2" title="STERGE"><i class="fa-regular fa-trash-can"></i></a></td>
                     </tr>

                     <tr>
                        <th scope="row"><a href="#"><img src="uploads/produse/1717686357_7916272.webp" alt="Produs x denumirea" width="90" /></a></th>
                        <td data-info="title"><a href="#"><strong>Produs x denumirea</strong></a></td>
                        <td data-info="price"><strong>145 lei</strong></td>
                        <td><a href="#" class="w-logout-btn" title="ADAUGA IN COS"><i class="fa-solid fa-basket-shopping"></i></a>
                        <a href="#" class="w-logout-btn ms-2" title="STERGE"><i class="fa-regular fa-trash-can"></i></a></td>
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