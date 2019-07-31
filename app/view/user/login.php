<div class="container">
    <section class="row justify-content-center">
        <div class="col-6">
          <img src="/images/monithon-logo.png" alt="Monithon" class="mx-auto d-block login-logo" />
          <h1>Login</h1>
            <form class="" method="post" action="/user/login">
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
