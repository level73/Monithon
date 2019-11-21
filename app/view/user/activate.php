<div class="container">
    <section class="row justify-content-center">
        <div class="col-6">
          <img src="/images/monithon-logo.png" alt="Monithon" class="mx-auto d-block login-logo" />
          <h1><?php t('Attivazione Account'); ?></h1>

          <?php if($activation){ ?>
          <h2><?php t('Il tuo account è attivo!'); ?></h2>
          <p>Il codice di attivazione è stato rimosso per la tua sicurezza. Puoi accedere a Monithon con le credenziali che hai scelto cliccando sul pulsante qui sotto.</p>
          <div class="row">
            <div class="col-3"></div>
            <div class="col-6"><a href="/user/login" class="btn btn-block btn-primary">LOGIN</a></div>
            <div class="col-3"></div>
          </div>
          <?php } else { ?>
            <h2>OOOOPS.</h2>
            <p>Qualcosa è andato storto. Per favore, controlla il link di attivazione.</p>
          <?php } ?>


        </div>
    </section>

</div>
