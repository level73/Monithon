<div class="container">
    <section class="row justify-content-center">
        <div class="col-12 col-md-6 mt-5 mb-5 animate__animated animate__fadeInLeft animate__slow">
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
        <?php
        if(isset($pfurl) && !empty($pfurl)){
            if(isset($project) && $project['code'] == 200){
        ?>
        <div class="col-12 col-md-6  mt-5 animate__animated animate__fadeInRight" id="login_prj">
            <div class="login_prj_inner">
                <p class="text-muted">sembra tu voglia monitorare questo progetto:</p>

                <h3>
                    <small><?php echo $project['data']->oc_tema_sintetico . ' - ' . $project['data']->cup_descr_tipologia; ?></small><br />
                    <?php echo $project['data']->oc_titolo_progetto; ?>
                </h3>
                <span class="login_prj_territories">
                <?php
                    $territori = array();
                    foreach($project['data']->territori as $territorio){
                        $territori[] = $territorio->denominazione;
                    }
                    echo implode(' | ', $territori);
                    ?>
                </span>
                <span class="login_prj_dates">
                    <?php echo ocDateFormatter($project['data']->oc_data_inizio_progetto) . ' - ' . ocDateFormatter($project['data']->oc_data_fine_progetto_prevista); ?>
                    <?php echo ' (' . $project['data']->oc_stato_progetto . ')'; ?>
                </span>
                <div class="login_prj_finance">

                    <span class="login_prj_data login_prj_labval">
                    <?php echo $project['data']->oc_finanz_tot_pub_netto; ?> &euro;
                    </span>
                    <span class="login_prj_labval login_prg_label">
                    Finanziamento Pubblico Netto
                    </span>
                </div>

                <div class="login_prj_buttons text-center">
                <a href="https://projectfinder.monithon.eu" class="btn btn-primary btn-sm" target="_blank">Vai al Project Finder</a>
                <a href="<?php echo $pfurl; ?>" class="btn btn-primary btn-sm" target="_blank">Approfondisci il progetto sul Portale OpenCoesione</a>
                </div>
            </div>
        </div>
        <?php
            }
        }
        ?>
    </section>

</div>
