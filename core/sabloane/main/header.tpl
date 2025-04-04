
<header>
<div class="w-header-area p-relative z-index-11">

   <div class="w-header-top theme-bg p-relative z-index-1 d-none d-md-block">
      <div class="container">
         <div class="row align-items-center">
            <div class="col-md-6">
               <div class="w-header-welcome d-flex align-items-center">
                  <p>{$ws_config.cfg_antet_site}</p>
               </div>
            </div>
            <div class="col-md-6">
               <div class="w-header-top-right d-flex align-items-center justify-content-end">
                  <div class="w-header-top-menu d-flex align-items-center justify-content-end">
                  {if ($CLIENT_ID>0)}
                     <div class="w-header-top-menu-item w-header-setting">
                        <span class="w-header-setting-toggle" id="w-header-setting-toggle"><i class="fa fa-user me-2"></i>Contul Meu</span>
                        <ul>
                           <li><a href="contul-meu/"><i class="fa-regular fa-id-card me-2"></i>Contul Meu</a></li>
                           <li><a href="contul-meu/informatii/"><i class="fa-regular fa-user-pen me-2"></i>Date personale</a></li>
                           <li><a href="contul-meu/comenzi/"><i class="fa-regular fa-rectangle-list me-2"></i>Comenzile Mele</a></li>                           
                           <li><a href="contul-meu/favorite/"><i class="fa-regular fa-heart me-2"></i>Produse Favorite</a></li>
                           <li><a href="contul-meu/securitate/"><i class="fa-regular fa-lock me-2"></i>Modificare Parola</a></li>
                           <li><a href="contul-meu/logout/"><i class="fa-regular fa-right-from-bracket me-2"></i>Logout</a></li>
                        </ul>
                     </div>
                  {else}   
                     <a href="inregistrare/" class="text-white me-2 p-1"><i class="fa fa-plus me-2"></i>Inregistrare</a>
                     <a href="login/" class="text-white ms-2 p-1"><i class="fa fa-user me-2"></i>Login client</a>
                   {/if}  
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="w-header-main w-header-sticky">
      <div class="container">
         <div class="row align-items-center">
            <div class="col-xl-2 col-lg-2 col-md-4 col-6">
               <div class="logo">
                  <a href="./"><img src="assets/images/logo.svg" alt="Logo"></a>
               </div>
            </div>
            <div class="col-xl-6 col-lg-7 d-none d-lg-block">
               <div class="w-header-search pl-70">
                  <form method="get" action="cautare/">
                     <div class="w-header-search-wrapper d-flex align-items-center">
                        <div class="w-header-search-box">
                           <input id="caut" name="caut" type="text" placeholder="Cauta in produse ...">
                        </div>
                        <div class="w-header-search-btn">
                           <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <div class="col-xl-4 col-lg-3 col-md-8 col-6">
               <div class="w-header-main-right d-flex align-items-center justify-content-end">

               <!-- CONTUL CLIENTULUI
                  <div class="w-header-login d-none d-lg-block">
                     <a href="contul-meu/" class="d-flex align-items-center">
                        <div class="w-header-login-icon">
                           <span><i class="fa-solid fa-user fs-18"></i></span>
                        </div>
                        <div class="w-header-login-content d-none d-xl-block">
                           <span>Ionescu Popescu</span>
                           <h5 class="w-header-login-title">Contul Meu</h5>
                        </div>
                     </a>
                  </div>
               -->

                  <div class="w-header-orders d-none d-lg-block me-5 ms-4">
                     <a href="tel:{$ws_config.head_phone_orders}" class="d-flex align-items-center">
                     <div class="w-header-orders-icon d-inline">
                        <span><i class="fa-solid fa-phone-volume"></i></span>
                     </div>
                     <div class="w-header-orders-content d-none d-xl-block">
                        <span class="mb-1">{$ws_config.head_phone_label}</span>
                        <h6>{$ws_config.head_phone_orders}</h6>
                     </div>
                     </a>
                  </div>


                  <a href="contul-meu/favorite/" class="w-header-action-btn hide-mobile ms-1 me-2" title="Produse FAVORITE">
                     <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.239 18.8538C13.4096 17.5179 15.4289 15.9456 17.2607 14.1652C18.5486 12.8829 19.529 11.3198 20.1269 9.59539C21.2029 6.25031 19.9461 2.42083 16.4289 1.28752C14.5804 0.692435 12.5616 1.03255 11.0039 2.20148C9.44567 1.03398 7.42754 0.693978 5.57894 1.28752C2.06175 2.42083 0.795919 6.25031 1.87187 9.59539C2.46978 11.3198 3.45021 12.8829 4.73806 14.1652C6.56988 15.9456 8.58917 17.5179 10.7598 18.8538L10.9949 19L11.239 18.8538Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M7.26062 5.05302C6.19531 5.39332 5.43839 6.34973 5.3438 7.47501" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                     </svg> 
                     <span class="w-header-action-badge">0</span>                          
                  </a>


                  <div class="w-header-action-item d-lg-none">
                  <a title="COSUL MEU">
                     <button type="button" class="w-header-action-btn w-mobile-item-btn w-search-open-btn">
                      <i class="flaticon-search-1"></i>
                     </button>
                  </a>   
                  </div>

                     <div class="w-header-action-item">
                        <button type="button" class="w-header-action-btn cartmini-open-btn">
                           <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M6.48626 20.5H14.8341C17.9004 20.5 20.2528 19.3924 19.5847 14.9348L18.8066 8.89359C18.3947 6.66934 16.976 5.81808 15.7311 5.81808H5.55262C4.28946 5.81808 2.95308 6.73341 2.4771 8.89359L1.69907 14.9348C1.13157 18.889 3.4199 20.5 6.48626 20.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M6.34902 5.5984C6.34902 3.21232 8.28331 1.27803 10.6694 1.27803V1.27803C11.8184 1.27316 12.922 1.72619 13.7362 2.53695C14.5504 3.3477 15.0081 4.44939 15.0081 5.5984V5.5984" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M7.70365 10.1018H7.74942" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M13.5343 10.1018H13.5801" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                           </svg>    
                           <span class="w-header-action-badge">{$TotalCosulMeu}</span>                                                                          
                        </button>
                     </div>

                     <div class="w-header-action-item d-lg-none">
                        <button type="button" class="w-header-action-btn w-offcanvas-open-btn">
                           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="16" viewBox="0 0 30 16">
                              <rect x="10" width="20" height="2" fill="currentColor"/>
                              <rect x="5" y="7" width="25" height="2" fill="currentColor"/>
                              <rect x="10" y="14" width="20" height="2" fill="currentColor"/>
                           </svg>
                        </button>
                     </div>
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="w-header-bottom w-header-bottom-border d-none d-lg-block">
      <div class="container">
         <div class="w-mega-menu-wrapper p-relative">
            <div class="row align-items-center">
               <div class="col-xl-3 col-lg-3">
                  <div class="w-header-category w-category-menu w-header-category-toggle">
                     <button class="w-category-menu-btn w-category-menu-toggle">
                        <span>
                           <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1C0 0.447715 0.447715 0 1 0H15C15.5523 0 16 0.447715 16 1C16 1.55228 15.5523 2 15 2H1C0.447715 2 0 1.55228 0 1ZM0 7C0 6.44772 0.447715 6 1 6H17C17.5523 6 18 6.44772 18 7C18 7.55228 17.5523 8 17 8H1C0.447715 8 0 7.55228 0 7ZM1 12C0.447715 12 0 12.4477 0 13C0 13.5523 0.447715 14 1 14H11C11.5523 14 12 13.5523 12 13C12 12.4477 11.5523 12 11 12H1Z" fill="currentColor"/>
                           </svg>
                        </span>     
                        Categorii produse                           
                     </button>
                     <nav class="w-category-menu-content">
                        {$ListCategorii}
                     </nav>
                  </div>
               </div>
               <div class="col-xl-9 col-lg-9">
                  <div class="main-menu menu-style-1">
                     <nav class="w-main-menu-content">
                        {$xTopMeniu}
                     </nav>
                  </div>
               </div>
               
            </div>

      </div>
   </div>
</div>
</header>
