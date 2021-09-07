<section class="container-fluid" id="profile-header">
    <div class="prf d-none"><?php echo $profile->idauth; ?></div>
    <div class="row  align-items-center">
        <div class="col-3 col-md-2">
            <?php avatar($profile, true, true); ?>
        </div>
        <div class="col-9 col-md-10">
            <h2 id="team_name"><?php echo $profile->username; ?></h2>
            <div class="row" id="geoloc">
                <div class="col-6">
                    <?php echo $profile->city; ?>
                    <?php if(isset($profile->ASOC)) { ?>
                        (<?php echo $profile->ASOC->provincia->shorthand; ?>) -
                        <?php echo $profile->ASOC->regione->region; ?>
                    <?php } ?>
                </div>
                <div class="col-6"><?php echo (!empty($profile->twitter) ? '<a href="https://twitter.com/'.$profile->twitter.'" title="Twitter Profile Link" target="_blank">'.$profile->twitter.'</a>' : ''); ?></div>
            </div>
        </div>
        <?php /*
        <div class="col-12 col-md-3 stat">
            <span class="stat-label">contribuisce con il</span>
            <span class="stat-number"><?php echo $ratio['ratio']; ?>%</span>
            <span class="stat-label">dei report</span>
            <span class="stat-descr"><?php echo $ratio['profile']; ?> su <?php echo $ratio['total']; ?></span>
        </div>
        */ ?>
    </div>
</section>
<?php if(isset($profile->ASOC)){ ?>
    <section class="container-fluid" id="asoc-profile">
        <div class="row">
            <div class="col-12">
                <span class="asoc-badge"><i class="fa fa-badge-check"></i> PARTECIPANTE ASOC <em><?php echo strtoupper($profile->ASOC->istituto . ' (' . $profile->ASOC->tipo_istituto. ')'); ?></em></span>
            </div>
        </div>
    </section>
<?php } ?>

<section class="container-fluid" id="profile-body">
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="content-wrapper">
                <h2><?php t("CHI SIAMO"); ?></h2>
                <p><?php echo $profile->bio; ?></p>
            </div>

            <div class="content-wrapper">
                <h2><?php t("MAPPA DEI REPORT"); ?></h2>
                <div id="profile-map"></div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="content-wrapper">
                <h2>I NOSTRI REPORT</h2>
                <?php foreach($reports as $report){ ?>
                <div class="report row">
                    <div class="col-12 col-md-9">
                        <h3><a href="/report/view/<?php echo $report->idreport_basic; ?>"><?php echo $report->titolo; ?></a></h3>
                        <span class="d-none latlng">[<?php echo $report->lat_ .','.$report->lon_; ?>]</span>
                        <time datetime="<?php echo $report->created_at; ?>"><?php echo strftime('%d/%m/%Y', strtotime($report->created_at)); ?></time>
                        <p><?php echo apiHellip($report->descrizione); ?></p>
                        <a href="/report/view/<?php echo $report->idreport_basic; ?>" class="btn btn-sm btn-primary">LEGGI TUTTO</a>
                    </div>
                    <div class="col-12 col-md-3">
                        <?php if(isset($report->images) && !empty($report->images)){ ?>
                            <div class="img-holder" style="background-image: url('<?php echo image($report->images[0]); ?>');"></div>
                        <?php } else { ?>
                            <div class="img-holder img-placeholder"><i class="fal fa-image-polaroid fa-3x"></i></div>
                        <?php } ?>
                        <span class=" giudizio-sintetico <?php echo cssify($report->giudizio_sintetico); ?>"><?php echo $report->giudizio_sintetico; ?></span>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
