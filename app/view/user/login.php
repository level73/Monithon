<div class="container">
    <section class="row justify-content-center">
        <div class="col-6">
          <img src="/images/monithon-logo.png" alt="Monithon" class="mx-auto d-block login-logo" />
            <?php if(isset($pfurl) && !empty($pfurl)){ ?>
                <h1>Grazie per aver deciso di eseguire un monitoraggio!</h1>
                <p>Per proseguire, è necessario <a href="/user/register">creare un account</a>, oppure accedere alla piattaforma in caso tu ti sia già registrato. </p>

            <?php } ?>
            <h1>Login <a href="/user/register">O REGISTRATI</a></h1>
            <form class="" method="post" action="">
                <?php if(isset($referrer)){ ?>
                <input type="hidden" name="r" value="<?php echo $referrer; ?>">
                <?php } ?>
                <div class="form-group">
                    <label for="email" class="sr-only">Email:</label>
                    <input type="email" name="email" placeholder="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="pwd" class="sr-only">Password:</label>
                    <input type="password" name="pwd" placeholder="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary"><i class="fal fa-sign-in"></i> LOGIN</button>
                <div class="row login-options">
                  <div class="col-6"><a href="/user/recover">Password dimenticata?</a></div>
                  <div class="col-6 text-right"><a href="/user/register">Registrati</a></div>
                </div>

            </form>
        </div>
    </section>

</div>
