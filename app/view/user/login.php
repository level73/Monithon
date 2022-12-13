<div class="container-fluid">
    <section class="row justify-content-center">

        <div class="col-12 col-md-12">
            <h1 class="text-center">
            <img src="/images/monithon-logo.png" alt="Monithon" class=" login-logo" />
            Benvenuto su Monithon
            </h1>
        </div>

        <div class="col-12 col-md-4 col-md-offset-2 mt-5 mb-5 animate__animated animate__fadeInLeft login-box">

            <p><strong>Monithon</strong> è un’iniziativa indipendente e nonprofit che ha l’obiettivo di <strong>monitorare l’efficacia dei fondi pubblici</strong>.</p>
            <p>Già tante associazioni e studenti lo stanno facendo in tutta Italia. <a href="https://reports.monithon.eu/">Leggi i report di monitoraggio civico</a> pubblicati sui progetti finanziati con soldi pubblici. <a href="mailto: redazione@monithon.eu">Scrivici</a> se vuoi essere coinvolto.</p>
            <?php
            if(isset($pfurl) && !empty($pfurl)){
                if(isset($project) && $project['code'] == 200){
            ?>
            <div id="login_prj">

                <div class="login_prj_inner">
                    <p class="text-muted">sembra tu voglia monitorare questo progetto:</p>

                    <h3>
                        <small><?php echo $project['data']->oc_tema_sintetico . ' - ' . $project['data']->cup_descr_tipologia; ?></small><br />
                        <a href="<?php echo $pfurl; ?>" target="_blank"><?php echo $project['data']->oc_titolo_progetto; ?></a>
                    </h3>
                <?php /*    <span class="login_prj_territories">
                <?php
                $territori = array();
                foreach($project['data']->territori as $territorio){
                    $territori[] = $territorio->denominazione;
                }
                echo implode(' | ', $territori);
                ?>
                </span> */ ?>
                    <span class="login_prj_dates">
                    <?php echo ocDateFormatter($project['data']->oc_data_inizio_progetto) . ' - ' . ocDateFormatter($project['data']->oc_data_fine_progetto_prevista); ?>
                    <?php echo ' (' . $project['data']->oc_stato_progetto . ')'; ?>
                </span>
                    <div class="login_prj_finance">

                    <span class="login_prj_data login_prj_labval">
                    <?php echo number_format((float)$project['data']->oc_finanz_tot_pub_netto, 2, ',', '.'); ?> &euro;
                    </span>
                        <span class="login_prj_labval login_prg_label">
                    Finanziamento Pubblico Netto
                    </span>
                    </div>
                </div>
            </div>

           <?php
                }
           }
           ?>
            <p></p>
            <p>Noi ti aiuteremo a diffondere il tuo report di monitoraggio civico presso i media e le istituzioni, valorizzando al massimo il tuo contributo o quello della tua associazione.</p>
        </div>


        <div class="col-12 col-md-4 mt-5 mb-5 animate__animated animate__fadeInRight login-box">
            <div class="">
                <p>Per creare un report ti devi registrare qui - ci basta una tua mail. Ti guideremo passo dopo passo sulle cose da fare. Ricorda:</p>
                <ul>
                    <li>Ti scriveremo solo ed esclusivamente per accompagnarti nella redazione del tuo report di monitoraggio</li>
                    <li>Non monitorare progetti in cui sei coinvolto direttamente, non saresti obiettivo!</li>
                    <li>Tutti i nostri strumenti sono gratuiti</li>
                </ul>




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
        </div>
    </section>

</div>
