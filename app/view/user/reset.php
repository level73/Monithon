<?php if ($redir == true){ ?>
<script>
  setTimeout(function () {
    window.location.href = "/user/login";
 }, 5000);
 </script>
<?php } ?>
<div class="container">
  <section class="row justify-content-center">
      <div class="col-6">
        <img src="/images/monithon-logo-2022.png" alt="Monithon" class="mx-auto d-block login-logo" />

      <?php if($pwd_reset == true){ ?>
      <form action="/user/reset/<?php echo $hash; ?>" method="post" class="login-form">
        <h3>Reset della Password</h3>
        <p>Compila il modulo per impostare la nuova password.</p>
        <div class="form-group">
          <label for="pwd">Nuova Password</label>
          <input type="password" name="pwd" id="pwd" class="form-control">
        </div>
        <div class="form-group">
          <label for="pwd_C">Conferma la Nuova Password</label>
          <input type="password" name="pwd_C" id="pwd_C" class="form-control">
        </div>
        <input type="hidden" value="<?php echo $hash; ?>" name="hash">
        <div class="from-group clearfix">

          <button type="submit" class="btn btn-primary pull-right">Imposta la nuova password</button>
        </div>
      </form>

    <?php } else { ?>
      <h2>Non abbiamo trovato il tuo account.</h2>
      <p>La URL sembra non essere valida.</p>
      <p>per favore contatta <a href="mailto:redazione@monithon.it">la Redazione</a> per sbloccare il tuo account.</p>

    <?php } ?>
    </div>
  </section>
</div>
