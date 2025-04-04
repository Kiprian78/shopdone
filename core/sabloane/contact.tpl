{include "main/begin.tpl"}
{include "main/preloader.tpl"}
{include "main/header.tpl"}
{include "main/header_sticky.tpl"}

<main>
{$BREADCRUMB}

<section class="w-contact-area pb-45 pt-15">
<div class="container">
<div class="row">

          <div class="col-11 mx-auto col-xl-4 col-lg-4 pb-30">
            <div class="w-contact-info-wrapper">
              <h3 class="w-contact-title">{$ws_config.ct_antet_1}</h3>            
              <div class="w-contact-info-item">
                <div class="w-contact-info-content">
            
                  <span class="color3-tema">Compania:</span>
                  <p>{$ws_config.ct_info_compania}</p>
                  <span class="color3-tema">Adresa:</span>
                  <p>{$ws_config.ct_info_adresa}</p>
                  <span class="color3-tema">Nr.Telefon:</span>
                  <p><a href="tel:{$ws_config.ct_info_telefon}">{$ws_config.ct_info_telefon}</a></p>
                  <span class="color3-tema">Adresa E-mail:</span>
                  <p><a href="mailto:{$ws_config.ct_info_email}">{$ws_config.ct_info_email}</a></p>
                  <span class="color3-tema">Informatii fiscale/facturare</span>
                  <p>{$ws_config.ct_info_financiar}</p> 

                  
                </div>
              </div>
              
              <div class="w-contact-info-item pt-3">
                <div class="w-contact-info-content">
                  <div class="w-contact-social-wrapper mt-5">
                    <h4 class="w-contact-social-title">{$ws_config.ct_antet_3}</h4>

                    <div class="w-contact-social-icon">
                      {$xSM}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



          <div class="col-11 mx-auto col-xl-8 col-lg-8">
            <div class="w-contact-wrapper">
              <h3 class="w-contact-title">{$ws_config.ct_antet_2}</h3>

              <div class="w-contact-form">
                <form id="contact-form" method="POST" action="contact/">
                  <div class="w-contact-input-wrapper">
                    <input type="hidden" id="ctToken" name="ctToken" value="890JH&^%$MH89780789YH6432$#k7868t%6786878yJKH$*iujh" />
                    <div class="w-contact-input-box">
                      <div class="w-contact-input">
                        <input name="numele" id="numele" type="text" class="fw-bold" required minlength="5" placeholder="Numele si Prenumele ...">
                      </div>
                      <div class="w-contact-input-title">
                        <label for="numele" class="color3-tema">Numele si Prenumele</label>
                      </div>
                    </div>
                    <div class="w-contact-input-box">
                      <div class="w-contact-input">
                        <input name="email" id="email" type="email" class="fw-bold" required minlength="5" placeholder="Adresa de email ...">
                      </div>
                      <div class="w-contact-input-title">
                        <label for="email" class="color3-tema">Adresa de E-mail</label>
                      </div>
                    </div>
                    <div class="w-contact-input-box">
                      <div class="w-contact-input">
                        <input name="telefon" id="telefon" type="text" class="fw-bold" required minlength="6" placeholder="Nr.Telefon ...">
                      </div>
                      <div class="w-contact-input-title">
                        <label for="telefon" class="color3-tema">Nr.Telefon</label>
                      </div>
                    </div>
                    <div class="w-contact-input-box">
                      <div class="w-contact-input">
                        <textarea id="comentarii" name="comentarii" class="fw-bold" required minlength="5" placeholder="Mesajul dvs aici ..."></textarea>
                      </div>
                      <div class="w-contact-input-title">
                        <label for="comentarii" class="color3-tema">Mesajul dvs</label>
                      </div>
                    </div>
                  </div>
                  <div class="w-contact-suggetions mb-20">
                    <div class="w-contact-remeber">
                      <input id="agree" name="agree" type="checkbox" value="1" required>
                      <label for="agree">{$ws_config.ct_agree_info}</label>
                    </div>
                  </div>
                  <div class="w-contact-btn">
                    <button type="submit" id="btnSend" name="btnSend" disabled class="w-100 w-lg-auto">{$ws_config.ct_btn_send}</button>
                  </div>
                </form>

              </div>
            </div>
          </div>

      </div>
    </div>
  </section>

  <section class="w-map-area pb-80">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <div class="w-map-wrapper">            
            <div class="w-map-iframe border rounded">
              <iframe src="{$ws_config.ct_google_map}"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>


{include "main/footer.tpl"}

<script>
ContactForm();
</script>

{include "main/end.tpl"}