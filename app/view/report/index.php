<div class="container" id="report-list">

    <header class="row">
        <div class="col-12">
            <h1>I REPORT</h1>
            <?php if(isset($search_params)): ?>
            <p>Con i parametri di ricerca che mi hai dato ho trovato <strong style="font-weight: 900;"><?php echo count($reports); ?> Report</strong>.</p>
            <?php else: ?>
            <small>Pagina <?php echo $curr_page; ?> di <?php echo ceil($total_reports / 10); ?></small>
            <?php /* <small>Abbiamo <strong><?php echo $total_reports; ?></strong> report su Monithon!</small> */ ?>
            <?php endif; ?>
            <hr>
        </div>
    </header>
    <section class="row" id="search-bar">
        <form class="col-md-12" method="get" id="search-form" action="/report">
            <input type="hidden" name="report-search" value="<?php echo bin2hex(random_bytes(12)); ?>">
            <fieldset>
                <legend>
                    <span style="background-color: white;">Cerca tra i report</span>
                </legend>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="report-title">Titolo del report</label>
                            <input type="text" class="form-control" id="report-title" name="report-title" placeholder="Titolo del report..." <?php if(isset($search_params['report-title'])) echo 'value="'.$search_params['report-title'].'"'; ?>>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="report-title">Tema</label>
                            <select class="form-control selectpicker" id="report-theme" name="report-theme" data-placeholder="Scegli il Tema...">
                                <option></option>
                                <option value="01" data-subtext="01"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "01" ? ' selected': ''; ?>>Ricerca e innovazione</option>
                                <option value="02" data-subtext="02"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "02" ? ' selected': ''; ?>>Reti e servizi digitali</option>
                                <option value="03" data-subtext="03"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "03" ? ' selected': ''; ?>>Competitività delle imprese</option>
                                <option value="04" data-subtext="04"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "04" ? ' selected': ''; ?>>Energia</option>
                                <option value="05" data-subtext="05"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "05" ? ' selected': ''; ?>>Ambiente</option>
                                <option value="06" data-subtext="06"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "06" ? ' selected': ''; ?>>Cultura e turismo</option>
                                <option value="07" data-subtext="07"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "07" ? ' selected': ''; ?>>Trasporti e mobilità</option>
                                <option value="08" data-subtext="08"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "08" ? ' selected': ''; ?>>Occupazione e lavoro</option>
                                <option value="09" data-subtext="09"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "09" ? ' selected': ''; ?>>Inclusione sociale e salute</option>
                                <option value="10" data-subtext="10"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "10" ? ' selected': ''; ?>>Servizi di cura infanzia e anziani</option>
                                <option value="11" data-subtext="11"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "11" ? ' selected': ''; ?>>Istruzione e formazione</option>
                                <option value="12" data-subtext="12"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "12" ? ' selected': ''; ?>>Rinnovamento urbano e rurale</option>
                                <option value="13" data-subtext="13"<?php echo isset($search_params['report-theme']) && $search_params['report-theme'] == "13" ? ' selected': ''; ?>>Rafforzamento capacità della PA</option>

                            </select>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="report-title">Giudizio di Efficacia</label>
                            <select class="form-control selectpicker" id="report-gde" name="report-gde">
                                <option></option>
                                <option value="1"<?php echo isset($search_params['report-gde']) && $search_params['report-gde'] == 1 ? ' selected': ''; ?>>Efficace</option>
                                <option value="2"<?php echo isset($search_params['report-gde']) && $search_params['report-gde'] == 2 ? ' selected': ''; ?>>Utile ma con problemi</option>
                                <option value="3"<?php echo isset($search_params['report-gde']) && $search_params['report-gde'] == 3 ? ' selected': ''; ?>>Inefficace o dannoso</option>
                                <option value="4"<?php echo isset($search_params['report-gde']) && $search_params['report-gde'] == 4 ? ' selected': ''; ?>>Non valutabile</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="report-title">Stato di Avanzamento*</label>
                            <select class="form-control selectpicker" id="report-sda" name="report-sda">
                                <option></option>
                                <option value="1"<?php echo isset($search_params['report-sda']) && $search_params['report-sda'] == 1 ? ' selected': ''; ?>>Appena avviato</option>
                                <option value="2"<?php echo isset($search_params['report-sda']) && $search_params['report-sda'] == 2 ? ' selected': ''; ?>>Mai partito</option>
                                <option value="3"<?php echo isset($search_params['report-sda']) && $search_params['report-sda'] == 3 ? ' selected': ''; ?>>In corso senza particolari intoppi</option>
                                <option value="4"<?php echo isset($search_params['report-sda']) && $search_params['report-sda'] == 4 ? ' selected': ''; ?>>In corso con problemi di realizzazione</option>
                                <option value="5"<?php echo isset($search_params['report-sda']) && $search_params['report-sda'] == 5 ? ' selected': ''; ?>>Bloccato</option>
                                <option value="6"<?php echo isset($search_params['report-sda']) && $search_params['report-sda'] == 6 ? ' selected': ''; ?>>Concluso</option>
                                <option value="7"<?php echo isset($search_params['report-sda']) && $search_params['report-sda'] == 7 ? ' selected': ''; ?>>Impossible verificare l'avanzamento</option>

                            </select>
                            <small class="help">* Al momento del monitoraggio</small>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-9">
                        <button type="submit" class="btn btn-primary">Cerca</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>

            </fieldset>
        </form>

    </section>

    <section class="reports">

    <?php foreach($reports as $report){ ?>
    <div class="report-list-entry">
        <div class="row">
                <div class="col-12">
                    <small>
                        <span class="report-date"><?php echo strftime('%d/%m/%Y', $report->create_date);?></span> |
                        <span class="report-author"><a href="/profile/view/<?php echo $report->profile; ?>"><?php echo ($report->role==4 || $report->report_type == 'lite') ? $report->username: $report->autore; //$author->username; ?></a></span>

                    </small>
                </div>
                <div class="col-9">
                    <h2>
                        <a href="/<?php echo $report->report_type; ?>/view/<?php echo $report->id; ?>"><?php echo $report->titolo; ?></a>
                    </h2>
                    <?php AsocExp($report); ?>
                    <?php if(!empty($report->descrizione)): ?>
                    <p class="report-description"><?php echo hellip($report->descrizione, 700); ?></p>
                    <?php else : ?>
                    <p class="report-description"><?php echo hellip($report->obiettivi, 700); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-3">
                    <?php if(isset($report->images) && !empty($report->images)){ ?>
                    <div class="img-holder" style="background-image: url('<?php echo image($report->images[0]); ?>');"></div>
                    <?php } else { ?>
                    <div class="img-holder img-placeholder"><i class="fal fa-image-polaroid fa-3x"></i></div>
                    <?php } ?>
                    <span class=" giudizio-sintetico <?php echo 'gde_'.$report->gs; ?>"><?php generateGDELabel($report->gs, $report->stato_di_avanzamento, 'main'); ?></span>
                    <?php /* <span class=" giudizio-sintetico <?php echo cssify($report->giudizio_sintetico); ?>"><?php echo $report->giudizio_sintetico; ?></span> */ ?>
                </div>

            <div class="col-12">
                <a href="/<?php echo $report->report_type; ?>/view/<?php echo $report->id; ?>" class="btn btn-primary btn-sm">Leggi il report</a>
            </div>

        </div>
    </div>
    <?php } ?>
    </section>
    <?php if(!isset($search_params)): ?>
    <section class="row" id="pagination">
        <nav aria-label="Report List Navigation" class="col-12">
            <ul class="pagination justify-content-center">


                <li class="page-item">
                    <a class="page-link <?php echo (is_null($prev_page) ? 'disabled' : ''); ?> " href="#" aria-label="Precedente">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php for($i = 1; $i <= (ceil($total_reports / 25)); $i++){ ?>
                <li class="page-item <?php echo($i == $curr_page ? 'active' : ''); ?>"><a class="page-link" href="/report/index/?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li class="page-item">
                    <a class="page-link <?php echo (is_null($next_page) ? 'disabled' : ''); ?>" href="#" aria-label="Successivo">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

    </section>
    <?php endif; ?>
</div>
