


<!-- div class="container-fluid" id="disclaimer-banner">
    <section class="row">
        <div class="col">
            <h3 class="text-center">this is the iMonitor Report Form. This functionality is currently a work in progress.</h3>
        </div>
    </section>
</div -->

<form class="" method="post" enctype="multipart/form-data" action="/imonitor/create">
    <div class="container">
        <section class="row intro">
            <div class="col">
                <div class="container-fluid">
                    <h1 class="text-center">iMonitor</h1>
                    <h3><?php echo HEAD_LABEL_CONTRACT; ?></h3>
                    <?php echo HEAD_PARAGRAPH_MONITUTOR; ?>

                </div>
            </div>
        </section>
        <section class="row">

            <div class="col">
                <fieldset>
                    <div class="input-group mb-4  mt-3">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="imonitor-contract-url-label"><?php echo HEAD_FIELD_OPENTENDER; ?></span>
                        </div>
                        <input
                                type="text"
                                class="form-control"
                                id="imonitor-contract-url"
                                name="imonitor[contract][opentender_url]"
                                placeholder="<?php echo HEAD_TEXT_OPENTENDER; ?>"
                                aria-label="Contract URL"
                                aria-describedby="imonitor-contract-url-label"
                                value="<?php if(isset($tender) && $tender != NULL){ echo 'https://opentender.eu/tender/' . $tender; } ?>"
                                >
                        <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="imonitor-opentender-lookup"><i class="fal fa-magnifying-glass"></i> <?php echo HEAD_BUTTON_IMPORTDATA; ?></button>
                        </div>

                    </div>
                </fieldset>
            </div>

        </section>

        <section class="row mt-3 mb-3">
            <div class="col">
                <h3 id="imonitor-ot-title">
                    <img
                        src=""
                        width="60"
                        alt=""
                        class="d-none"
                    >
                    <span></span>
                </h3>

                <input type="hidden" name="imonitor[contract][opentender_json]" id="opentender-json">

            </div>
        </section>
        <section class="row">
            <div class="col">


                <div class="mb-4 mt-3">
                    <label for="imonitor-report-title"><?php echo S1_FIELD_TITLE; ?></label>
                    <input type="text" class="form-control" id="imonitor-report-title" name="imonitor[report][title]" placeholder="<?php echo S1_HELP_TITLE; ?>" aria-label="Report title" aria-describedby="imonitor-report-title">
                </div>
                <div class="mb-4 mt-3">
                    <label for="imonitor-report-author"><?php echo S1_FIELD_AUTHOR; ?></label>
                    <small class="help"><?php echo S1_HELP_AUTHOR; ?></small>
                    <input type="text" class="form-control" id="imonitor-report-author" name="imonitor[report][author]" placeholder="Author..." aria-label="Author of the report" aria-describedby="imonitor-report-author">

                </div>
            </div>
        </section>

        <nav class="row mt-4 mb-4">
            <div class="col">
                <ul class="nav nav-tabs nav-fill" id="imonitor-report-nav" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="desk-analysis-tab" data-toggle="tab" href="#desk-analysis-tab-pane" role="tab" aria-controls="desk-analysis-tab-pane" aria-selected="true"><?php echo NAV_TAB_1; ?></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contract-implementation-tab" data-toggle="tab" href="#contract-implementation-tab-pane"  role="tab" aria-controls="contract-implementation-tab-pane" aria-selected="false"><?php echo NAV_TAB_2; ?></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="results-and-impact-tab" data-toggle="tab" href="#results-and-impact-tab-pane"  role="tab" aria-controls="results-and-impact-tab-pane" aria-selected="false"><?php echo NAV_TAB_3; ?></a>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="tab-content" id="imonitor-report-tab-content">
            <div class="tab-pane fade show active" id="desk-analysis-tab-pane" role="tabpanel" aria-labelledby="desk-analysis-tab" tabindex="0">

                <div class="monitutor">
                    <h5><?php echo S1_TITLE_LABEL; ?> - <?php echo S1_TITLE_TEXT; ?></h5>
                    <?php echo S1_PARAGRAPH_TEXT; ?>
                </div>
                <section class="row">
                    <div class="col">
                        <fieldset>
                            <legend><span><?php echo S1SA_LABEL_TEXT; ?></span></legend>

                            <div class="mb-4 mt-3">
                                <label><?php echo S1SA_FIELD_EUFUNDED;?></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="imonitor[report][eu_funded]" id="imonitor-report-eu-funded1" value="2">
                                    <label class="form-check-label" for="imonitor-report-eu-funded1">
                                        <?php echo GENERIC_RADIOLABEL_YES; ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="imonitor[report][eu_funded]" id="imonitor-report-eu-funded2" value="1">
                                    <label class="form-check-label" for="imonitor-report-eu-funded2">
                                        <?php echo GENERIC_RADIOLABEL_NO; ?>
                                    </label>
                                </div>

                            </div>

                            <div class="mb-4 mt-3 eu-funded-eval">
                                <label for="imonitor-report-project-url"><?php echo S1SA_FIELD_EUFUNDINFO; ?></label>
                                <small class="help"><?php echo S1SA_HELP_EUFUNDINFO; ?></small>
                                <input type="text" class="form-control" id="imonitor-report-project-url" name="imonitor[report][project_url]" placeholder="URL..." aria-label="Project URL" aria-describedby="imonitor-report-project-url">

                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-4 mt-3">
                                        <label for="imonitor-report-project-funding"><?php echo S1SA_FIELD_FUNDINGAMOUNT; ?></label>
                                        <input type="number" step=".01" class="form-control" id="imonitor-report-project-funding" name="imonitor[report][project_funding]" placeholder="Project funding..." aria-label="Project funding" aria-describedby="imonitor-report-project-funding">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-4 mt-3">
                                        <label for="imonitor-report-project-policy"><?php echo S1SA_FIELD_MAINPOLICY; ?></label>
                                        <select class="custom-select" id="imonitor-report-project-policy" name="imonitor[report][project_policy]" placeholder="<?php echo S1SA_FIELD_MAINPOLICY; ?>" aria-label="Project policy" aria-describedby="imonitor-report-project-policy">
                                            <option></option>
                                            <option value="1"><?php echo S1SA_OPTION_MAINPOLICY_1; ?></option>
                                            <option value="2"><?php echo S1SA_OPTION_MAINPOLICY_2; ?></option>
                                            <option value="3"><?php echo S1SA_OPTION_MAINPOLICY_3; ?></option>
                                            <option value="4"><?php echo S1SA_OPTION_MAINPOLICY_4; ?></option>
                                            <option value="5">Cultura e turismo</option>
                                            <option value="6">Inclusione sociale</option>
                                            <option value="7">Salute</option>
                                            <option value="8">Energia</option>
                                            <option value="9">Riqualificazione urbana e rurale</option>
                                            <option value="10">Competitività delle imprese</option>
                                            <option value="11">Occupazione e lavoro</option>
                                            <option value="12">Ordine pubblico e sicurezza</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 mt-3">
                                <label for="imonitor-report-project-cup">Codice CUP del Progetto</label>
                                <small class="help">Controlla e verifica che il codice CUP sia corretto. Se è mancante, inserisci qui il codice CUP. Puoi inserire il CUP sulla piattaforma <a href="https://www.opencup.gov.it/portale/web/opencup/home" target="_blank">OpenCUP</a> per ricercare altre informazioni sul progetto.</small>
                                <input type="text" class="form-control" id="imonitor-report-project-cup" name="imonitor[report][project_cup]" placeholder="Codice CUP..." aria-label="Codice CUP" aria-describedby="imonitor-report-project-cup">
                            </div>
                            <div class="mb-4 mt-3">
                                <label for="imonitor-report-project-programme"><?php echo S1SA_FIELD_PROGRAMME; ?></label>
                                <small class="help"><?php echo S1SA_HELP_PROGRAMME; ?></small>
                                <input type="text" class="form-control" id="imonitor-report-project-programme" name="imonitor[report][project_programme]" placeholder="Policy Programme..." aria-label="Policy Programme" aria-describedby="imonitor-report-project-programme">
                            </div>

                        </fieldset>

                    </div>
                </section>

                <section class="row">
                    <div class="col">
                        <fieldset>
                            <legend><span><?php echo S1SB_LABEL_TEXT; ?></span></legend>
                            <p><?php echo S1SB_PARAGRAPH_TEXT; ?></p>
                            <div class="mb-4 mt-3">
                                <label for="imonitor-report-contract-title"><?php echo S1SB_FIELD_CONTRACTTITLE; ?></label>
                                <input type="text" class="form-control" id="imonitor-report-contract-title" name="imonitor[report][contract_title]" placeholder="<?php placeholderize(S1SB_FIELD_CONTRACTTITLE); ?>" aria-label="Contract title" aria-describedby="imonitor-report-contract-title">
                            </div>
                            <div class="mb-4 mt-3">
                                <label for="imonitor-report-contract-object"><?php echo S1SB_FIELD_CONTRACTOBJECT; ?></label>
                                <small class="help"><?php echo S1SB_HELP_CONTRACTOBJECT; ?></small>
                                <input type="text" class="form-control" id="imonitor-report-contract-object" name="imonitor[report][contract_object]" placeholder="<?php placeholderize(S1SB_HELP_CONTRACTOBJECT); ?>" aria-label="Contract object" aria-describedby="imonitor-report-contract-object">
                            </div>
                            <div class="mb-4 mt-3">
                                <label for="imonitor-report-contract-cig">CIG del Contratto</label>
                                <small class="help">Controlla e verifica che il CIG sia corretto. Se è mancante, inserisci qui il CIG. Puoi cercare il CIG sulla <a href="https://dati.anticorruzione.it/superset/dashboard/appalti/" target="_blank">Banca Dati Nazionale dei COntratti Pubblici (ANAC)</a> per verificare o ricercare informazioni sul contratto.</small>
                                <input type="text" class="form-control" id="imonitor-report-contract-cig" name="imonitor[report][contract_cig]" placeholder="CIG..." aria-label="CIG" aria-describedby="imonitor-report-contract-cig">
                            </div>
                            <div class="mb-4 mt-3">
                                <label for="imonitor-report-contract-body"><?php echo S1SB_FIELD_CONTRACTINGBODY; ?></label>
                                <small class="help"><?php echo S1SB_HELP_CONTRACTINGBODY; ?></small>
                                <input type="text" class="form-control" id="imonitor-report-contract-body" name="imonitor[report][contract_body]" placeholder="<?php placeholderize(S1SB_FIELD_CONTRACTINGBODY); ?>" aria-label="Contract body" aria-describedby="imonitor-report-contract-body">
                            </div>

                            <div class="mb-4 mt-3">
                                <!-- #TODO Is this to be found in hte Lots? -->
                                <label for="imonitor-report-contract-supplier"><?php echo S1SB_FIELD_SUPPLIER; ?></label>
                                <small class="help"><?php echo S1SB_HELP_SUPPLIER; ?></small>
                                <input type="text" class="form-control" id="imonitor-report-contract-supplier" name="imonitor[report][contract_supplier]" placeholder="<?php placeholderize(S1SB_FIELD_SUPPLIER); ?>" aria-label="Contract supplier" aria-describedby="imonitor-report-contract-supplier">
                            </div>

                            <div class="mb-4 mt-3">
                                <label for="imonitor-report-contract-value"><?php echo S1SB_FIELD_CONTRACTVALUE; ?></label>
                                <small class="help"><?php echo S1SB_HELP_CONTRACTVALUE; ?></small>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                                    <input type="text" class="form-control" id="imonitor-report-contract-value" name="imonitor[report][contract_value]" placeholder="€..." aria-label="Contract value" aria-describedby="imonitor-report-contract-value">
                                </div>
                            </div>

                            <div class="mb-4 mt-3">
                                <h4><?php echo S1SB_LABEL_CONTRACTINTEGRITY; ?> <span id="integrity-profile-score"></span></h4>

                                <table class="table-bordered table table-striped" id="imonitor-contract-integrity">
                                    <thead>
                                    <tr>
                                        <th><?php echo INTEGRITY_LABEL_INDICATOR; ?></th>
                                        <th class="text-center"><?php echo INTEGRITY_LABEL_SCORE; ?></th>
                                        <th><?php echo INTEGRITY_LABEL_RAW_VALUE; ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>

                            <div class="mb-4 mt-3">
                                <span  class="form-label"><?php echo S1SB_FIELD_CONTRACTTYPE; ?></span>
                                <small class="help"><?php echo S1SB_HELP_CONTRACTTYPE; ?></small>
                                <br />
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="imonitor[report][contract_type]" id="imonitor-report-contract-type1" value="Goods">
                                    <label class="form-check-label" for="imonitor-report-contract-type1">
                                        <?php echo S1SB_RADIOLABEL_CONTRACTTYPE_1; ?><br />
                                        <small class="help"><?php echo S1SB_RADIOLABEL_HELP_CONTRACTTYPE_1; ?></small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="imonitor[report][contract_type]" id="imonitor-report-contract-type2" value="Works">
                                    <label class="form-check-label" for="imonitor-report-contract-type2">
                                        <?php echo S1SB_RADIOLABEL_CONTRACTTYPE_2; ?><br />
                                        <small class="help"><?php echo S1SB_RADIOLABEL_HELP_CONTRACTTYPE_2; ?></small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="imonitor[report][contract_type]" id="imonitor-report-contract-type3" value="Services">
                                    <label class="form-check-label" for="imonitor-report-contract-type3">
                                        <?php echo S1SB_RADIOLABEL_CONTRACTTYPE_3; ?><br />
                                        <small class="help"><?php echo S1SB_RADIOLABEL_HELP_CONTRACTTYPE_3; ?></small>
                                    </label>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-4 mt-3">
                                        <label for="imonitor-report-contract-signature-date"><?php echo S1SB_FIELD_SIGNATUREDATE; ?></label>
                                        <input type="date" class="form-control" id="imonitor-report-contract-signature-date" name="imonitor[report][contract_signature_date]" placeholder="Contract signature date..." aria-label="Contract signature date" aria-describedby="imonitor-report-contract-signature-date">
                                        <small class="help"><?php echo S1SB_HELP_SIGNATUREDATE; ?></small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-4 mt-3">
                                        <label for="imonitor-report-contract-date-start"><?php echo S1SB_FIELD_STARTDATE; ?></label>
                                        <input type="date" class="form-control" id="imonitor-report-contract-date-start" name="imonitor[report][contract_date_start]" placeholder="Contract start date..." aria-label="Contract start date" aria-describedby="imonitor-report-contract-date-start">
                                        <small class="help"><?php echo S1SB_HELP_STARTDATE; ?></small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-4 mt-3">
                                        <label for="imonitor-report-contract-date-end"><?php echo S1SB_FIELD_ENDDATE; ?></label>
                                        <input type="date" class="form-control" id="imonitor-report-contract-date-end" name="imonitor[report][contract_date_end]" placeholder="Contract end date..." aria-label="Contract end date" aria-describedby="imonitor-report-contract-date-end">
                                        <small clasS="help"><?php echo S1SB_HELP_ENDDATE; ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 mb-4">
                                <label for="imonitor-report-contract-site-0"><?php echo S1SB_FIELD_DELIVERYSITE; ?></label>
                                <small class="help"><?php echo S1SB_HELP_DELIVERYSITE; ?></small>

                                <div class="" id="imonitor-report-contract-site-wrapper-0" data-flat-name="imonitor[report][contract_site]" >
                                    <input type="text" class="form-control address" id="imonitor-report-contract-site-0" data-flat-name="imonitor[report][contract_site]"  data-particle-name="address" name="imonitor[report][contract_site][0][address]" placeholder="<?php placeholderize(S1SB_FIELD_DELIVERYSITE); ?>" aria-label="Contract site" aria-describedby="imonitor-report-contract-site">
                                </div>
                                <div class="btn-group" role="group" aria-label="address group fields repeater">
                                    <button class="btn btn-sm btn-outline-secondary repeater mt-2 mb-2" data-repeater-target="#imonitor-report-contract-site-wrapper-0" type="button">
                                        <i class="fal fa-plus"></i> <?php echo S1SB_BUTTON_ADDDELIVERYSITE; ?>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary mt-2 mb-2" type="button" id="setMapMarkers"><i class="fal fa-location-dot"></i> <?php echo S1SB_BUTTON_ADDMAPMARKERS; ?></button>
                                </div>
                            </div>
                            <div class="mt-3 mb-4">
                                <div id="imonitor-contract-sites-map"></div>
                            </div>
                            <input type="text"  class="d-none" id="imonitor-report-contract-sites" name="imonitor[report][contract_sites]">


                            <div class="mb-4 mt-3">
                                <label for="imonitor-report-contract-delivery-schedule"><?php echo S1SB_FIELD_DELIVERYSCHEDULE; ?></label>
                                <small class="help"><?php echo S1SB_HELP_DELIVERYSCHEDULE; ?></small>
                                <input type="text" class="form-control" id="imonitor-report-contract-delivery-schedule" name="imonitor[report][delivery_schedule]" placeholder="<?php placeholderize(S1SB_FIELD_DELIVERYSCHEDULE); ?>" aria-label="Contract delivery schedule" aria-describedby="imonitor-report-contract-delivery-schedule">
                            </div>


                            <div class="mb-4 mt-3">
                                <label for="imonitor-report-contract-supervisor"><?php echo S1SB_FIELD_SUPERVISOR; ?>
                                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#imonitor-modal-contract-supervisor"><i class="fal fa-question-circle"></i></button>
                                </label>
                                <small class="help"><?php echo S1SB_HELP_SUPERVISOR; ?></small>
                                <input type="text" class="form-control" id="imonitor-report-contract-supervisor" name="imonitor[report][supervisor]" placeholder="Contract supervisor..." aria-label="Contract supervisor" aria-describedby="imonitor-report-contract-supervisor">
                            </div>


                            <span  class="form-label"><?php echo S1SB_LABEL_SUBCONTRACTING; ?> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#imonitor-modal-contract-subcontracting"><i class="fal fa-question-circle"></i></button></span>
                            <small class="help"><?php echo S1SB_HELP_SUBCONTRACTING; ?></small>
                            <br />
                            <div class="form-check">
                                <input class="form-check-input trigger-display show-dependency" data-target="#subcontractors" type="radio" name="imonitor[report][contract_subcontracting]" id="imonitor-report-contract-subcontracting1" value="Yes">
                                <label class="form-check-label" for="imonitor-report-contract-subcontracting1">
                                    <?php echo GENERIC_RADIOLABEL_YES; ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input trigger-display" data-target="#subcontractors" type="radio" name="imonitor[report][contract_subcontracting]" id="imonitor-report-contract-subcontracting2" value="No">
                                <label class="form-check-label" for="imonitor-report-contract-subcontracting2">
                                    <?php echo GENERIC_RADIOLABEL_NO; ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input trigger-display" type="radio" data-target="#subcontractors" name="imonitor[report][contract_subcontracting]" id="imonitor-report-contract-subcontracting3" value="Unknown">
                                <label class="form-check-label" for="imonitor-report-contract-subcontracting3">
                                    <?php echo GENERIC_RADIOLABEL_UNKNOWN; ?>
                                </label>
                            </div>

                            <div class="col d-none mt-3 mb-4" id="subcontractors">

                                <div class="form-label"><?php echo S1SB_LABEL_SUBCONTRACTORS; ?> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#imonitor-modal-contract-subcontractors"><i class="fal fa-question-circle"></i></button></div>

                                <div class="row" id="imonitor-report-contract-subcontractor-0" data-flat-name="imonitor[report][subcontractors]">
                                    <div class="col">
                                        <input type="text" class="form-control subcontractor" id="imonitor-report-contract-subcontractor-name-0" data-flat-name="imonitor[report][subcontractors]" data-particle-name="name" name="imonitor[report][subcontractors][0][name]" placeholder="<?php echo S1SB_FIELD_SUBCONTRACTORS_NAME; ?>" aria-label="Subcontractor name" aria-describedby="imonitor-report-subcontractor">
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text">€</span>
                                            </div>
                                            <input type="number" class="form-control subcontractor subcontract-value" id="imonitor-report-contract-subcontractor-value-0" data-flat-name="imonitor[report][subcontractors]" data-particle-name="value" name="imonitor[report][subcontractors][0][value]" placeholder="<?php echo S1SB_FIELD_SUBCONTRACTORS_VALUE; ?>" aria-label="Subcontract value" aria-describedby="imonitor-report-subcontractor">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary repeater mt-2 mb-2" data-repeater-target="#imonitor-report-contract-subcontractor-0" type="button"><i class="fal fa-plus"></i> <?php echo S1SB_BUTTON_ADDSUBCONTRACTORS; ?></button>


                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4 mt-3">
                                            <label for="imonitor-report-contract-subcontracting-value"><?php echo S1SB_LABEL_VALUESUBCONTRACTS; ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                                                <input type="number" class="form-control" step=".01"  id="imonitor-report-contract-subcontracting-value" name="imonitor[report][subcontracting_value]" placeholder="Contract subcontracting value..." aria-label="Contract subcontracting value" aria-describedby="imonitor-report-contract-subcontracting-value">
                                                <div class="input-group-append"><button class="btn btn-outline-secondary calcaggro" type="button" data-to-aggregate=".subcontract-value" data-aggro-field="#imonitor-report-contract-subcontracting-value"><i class="fal fa-calculator"></i> <?php echo GENERIC_BUTTON_CALCULATE; ?></button></div>
                                            </div>
                                            <small class="help"><?php echo S1SB_HELP_VALUESUBCONTRACTS; ?></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-4 mt-3">
                                            <label for="imonitor-report-contract-subcontracting-value"><?php echo S1SB_LABEL_PERCENTAGESUBCONTRACTS; ?></label>
                                            <div class="input-group">
                                                <input type="number" step=".01" class="form-control" id="imonitor-report-contract-subcontracting-percentage" name="imonitor[report][subcontracting_percentage]" placeholder="Contract subcontracting percentage..." aria-label="Contract subcontracting percentage" aria-describedby="imonitor-report-contract-subcontracting-percentage">
                                                <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                                <button class="btn btn-outline-secondary calcpercent" type="button" data-full-percentage="#imonitor-report-contract-value" data-partial-percentage="#imonitor-report-contract-subcontracting-value" data-percent-field="#imonitor-report-contract-subcontracting-percentage"><i class="fal fa-calculator"></i> <?php echo GENERIC_BUTTON_CALCULATE; ?></button>
                                                </div>
                                            </div>
                                            <small class="help"><?php echo S1SB_HELP_PERCENTAGESUBCONTRACTS; ?></small>
                                        </div>
                                    </div>
                                </div>




                            </div>


                            <div  class="form-label mt-3"><?php echo S1SB_LABEL_CONTRACTMOD; ?> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#imonitor-modal-contract-modifications"><i class="fal fa-question-circle"></i></button></div>
                            <small class="help"><?php echo S1SB_HELP_CONTRACTMOD; ?> </small>
                            <br />
                            <div class="form-check">
                                <input class="form-check-input trigger-display show-dependency contract-modifications-subdep-trigger" data-target="#contract-modifications" type="radio" name="imonitor[report][contract_modifications]" id="imonitor-report-contract-modifications1" value="Yes">
                                <label class="form-check-label" for="imonitor-report-contract-modifications1">
                                    <?php echo GENERIC_RADIOLABEL_YES; ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input trigger-display contract-modifications-subdep-trigger" data-target="#contract-modifications" type="radio" name="imonitor[report][contract_modifications]" id="imonitor-report-contract-modifications2" value="No">
                                <label class="form-check-label" for="imonitor-report-contract-modifications2">
                                    <?php echo GENERIC_RADIOLABEL_NO; ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input trigger-display contract-modifications-subdep-trigger" type="radio" data-target="#contract-modifications" name="imonitor[report][contract_modifications]" id="imonitor-report-contract-modifications3" value="Unknown">
                                <label class="form-check-label" for="imonitor-report-contract-modifications3">
                                    <?php echo GENERIC_RADIOLABEL_UNKNOWN; ?>
                                </label>
                            </div>

                            <div class="col d-none  mt-3 mb-4" id="contract-modifications">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4 mt-3">
                                            <label for="imonitor-report-contract-modification-date"><?php echo S1SB_LABEL_EXTENDEDDATE; ?></label>
                                            <input type="date" class="form-control" id="imonitor-report-contract-modification-date" name="imonitor[report][contract_modification_date]" placeholder="Contract modification date..." aria-label="Contract modification date" aria-describedby="imonitor-report-contract-modification-date">
                                            <small class="help"><?php echo S1SB_HELP_EXTENDEDDATE; ?></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-4 mt-3">
                                            <label for="imonitor-report-contract-modification-days"><?php echo S1SB_LABEL_DAYSEXTENDED; ?></label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="imonitor-report-contract-modification-days" name="imonitor[report][contract_modification_days]" placeholder="Contract modification days..." aria-label="Contract modification days" aria-describedby="imonitor-report-contract-modification-days">
                                                <div class="input-group-append">
                                                <button class="btn btn-outline-secondary calcdatediff" type="button" data-end-date="#imonitor-report-contract-date-end" data-modified-date="#imonitor-report-contract-modification-date" data-date-field="#imonitor-report-contract-modification-days"><i class="fal fa-calculator"></i> <?php echo GENERIC_BUTTON_CALCULATE; ?></button>
                                                </div>
                                            </div>
                                            <small class="help"><?php echo S1SB_HELP_DAYSEXTENDED; ?></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-4 mt-3">
                                            <label for="imonitor-report-contract-modification-days-percent"><?php echo S1SB_LABEL_PERCENTINCREASEDURATION; ?></label>
                                            <div class="input-group">
                                                <input type="number" step=".01" class="form-control" id="imonitor-report-contract-modification-days-percent" name="imonitor[report][contract_modification_days_percent]" placeholder="Contract modification days..." aria-label="Contract modification days" aria-describedby="imonitor-report-contract-modification-days">
                                                <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                                <button class="btn btn-outline-secondary calcpercent dates" type="button" data-start-date="#imonitor-report-contract-date-start" data-end-date="#imonitor-report-contract-date-end" data-days-diff="#imonitor-report-contract-modification-days" data-percent-field="#imonitor-report-contract-modification-days-percent"><i class="fal fa-calculator"></i> <?php echo GENERIC_BUTTON_CALCULATE; ?></button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4 mt-3">
                                            <label for="imonitor-report-contract-modification-value"><?php echo S1SB_LABEL_NEWCONTRACTVALUE; ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"> <span class="input-group-text">€</span></div>
                                                <input type="number" class="form-control" id="imonitor-report-contract-modification-value" name="imonitor[report][contract_modification_value]" placeholder="Contract modification value..." aria-label="Contract modification value" aria-describedby="imonitor-report-contract-modification-value">
                                            </div>
                                            <small class="help"><?php echo S1SB_HELP_NEWCONTRACTVALUE; ?></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-4 mt-3">
                                            <label for="imonitor-report-contract-modification-value-diff"><?php echo S1SB_LABEL_NEWCONTRACTVALUEDIFF; ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">€</span></div>
                                                <input type="number" class="form-control" id="imonitor-report-contract-modification-value-diff" name="imonitor[report][contract_modification_value_diff]" placeholder="Contract modification value difference..." aria-label="Contract modification vlaue difference" aria-describedby="imonitor-report-contract-modification-value-diff">
                                                <div class="input-group-append"><button class="btn btn-outline-secondary calcdiff" type="button" data-fullvalue="#imonitor-report-contract-value" data-newvalue="#imonitor-report-contract-modification-value" data-diff-field="#imonitor-report-contract-modification-value-diff"><i class="fal fa-calculator"></i> <?php echo GENERIC_BUTTON_CALCULATE; ?></button></div>
                                            </div>
                                            <small class="help"><?php echo S1SB_HELP_NEWCONTRACTVALUEDIFF; ?></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-4 mt-3">
                                            <label for="imonitor-report-contract-modification-value-percent"><?php echo S1SB_LABEL_PERCENTINCREASEVALUE; ?></label>
                                            <div class="input-group">
                                                <input type="number" step=".01" class="form-control" id="imonitor-report-contract-modification-value-percent" name="imonitor[report][contract_modification_value_percent]" placeholder="Contract modification %..." aria-label="Contract modification %" aria-describedby="imonitor-report-contract-modification-value-percent">
                                                <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                                <button class="btn btn-outline-secondary calcpercent" type="button" data-full-percentage="#imonitor-report-contract-value" data-partial-percentage="#imonitor-report-contract-modification-value-diff" data-percent-field="#imonitor-report-contract-modification-value-percent"><i class="fal fa-calculator"></i> <?php echo GENERIC_BUTTON_CALCULATE; ?></button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </fieldset>
                    </div>
                </section>

                <section class="row">
                    <div class="col">
                        <fieldset>
                            <legend><span><?php echo S1SC_LABEL_TEXT; ?></span></legend>
                            <small class="help">
                                <?php echo S1SC_MAIN_HELP; ?>
                            </small>
                            <div id="supplier-0">
                                <div class="form-label mt-3 mb-4"><?php echo S1SC_LABEL_COMPANYINFO; ?></div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-name" class="form-label"><?php echo S1SC_LABEL_COMPANYNAME; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-name" name="imonitor[report][supplier_name]">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4"><label for="imonitor-report-supplier-address" class="form-label"><?php echo S1SC_LABEL_COMPANYADDRESS; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-address" name="imonitor[report][supplier_address]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-postcode" class="form-label"><?php echo S1SC_LABEL_COMPANYPOSTALCODE; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-postcode" name="imonitor[report][supplier_postcode]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-city" class="form-label"><?php echo S1SC_LABEL_COMPANYCITY; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-city" name="imonitor[report][supplier_city]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-nuts" class="form-label"><?php echo S1SC_LABEL_COMPANYNUTSCODE; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-nuts" name="imonitor[report][supplier_nuts]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-country" class="form-label"><?php echo S1SC_LABEL_COMPANYCOUNTRY; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-country" name="imonitor[report][supplier_country]">
                                    </div>
                                </div>
                                <div class="form-label mt-3 mb-4"><?php echo S1SC_LABEL_COMPANYCONTACTINFO; ?></div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-phone" class="form-label"><?php echo S1SC_LABEL_COMPANYPHONENUMBER; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-phone" name="imonitor[report][supplier_phone]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-email" class="form-label"><?php echo S1SC_LABEL_COMPANYEMAIL; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-email" name="imonitor[report][supplier_email]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-website" class="form-label"><?php echo S1SC_LABEL_COMPANYWEBSITE;?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-website" name="imonitor[report][supplier_website]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-other" class="form-label"><?php echo S1SC_LABEL_COMPANYOTHER; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-other" name="imonitor[report][supplier_other]">
                                    </div>
                                </div>
                                <div class="form-label mt-3 mb-4"><?php echo S1SC_LABEL_COMPANYREGISTRATIONINFO; ?></div>
                                <small class="help"><?php echo S1SC_COMPANY_HELP; ?></small>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-company_id" class="form-label"><?php echo S1SC_LABEL_COMPANYREGISTRATIONID; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-company_id" name="imonitor[report][supplier_company_id]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label class="form-label d-block"><?php echo S1SC_LABEL_COMPANYIDTYPE; ?></label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"  id="imonitor-report-supplier-idtype_vat" value="VAT" name="imonitor[report][supplier_id_type]">
                                            <label class="form-check-label" for="imonitor-report-supplier-idtype_vat"><?php echo S1SC_LABEL_COMPANYIDTYPE_1; ?></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="imonitor[report][supplier_id_type]" id="imonitor-report-supplier-idtype_registry" value="REGISTRY">
                                            <label class="form-check-label" for="imonitor-report-supplier-idtype_registry"><?php echo S1SC_LABEL_COMPANYIDTYPE_2; ?></label>
                                        </div>


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-activitycodes" class="form-label"><?php echo S1SC_LABEL_COMPANYBUSINESSACTIVITYCODES; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-activitycodes" name="imonitor[report][supplier_activitycodes]">
                                        <small class="help"><?php echo S1SC_COMPANY_BUSINESS_CODES; ?></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-foundation" class="form-label"><?php echo S1SC_LABEL_COMPANYFOUNDATION; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-foundation" name="imonitor[report][supplier_foundation]">
                                        <small class="help"><?php echo S1SC_COMPANY_AGE; ?></small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-legalrep" class="form-label"><?php echo S1SC_LABEL_COMPANYLEGALREP; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-legalrep" name="imonitor[report][supplier_legalrep]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-shareholder" class="form-label"><?php echo S1SC_LABEL_COMPANYSHAREHOLDERS; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-shareholder" name="imonitor[report][supplier_shareholder]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-other_individual" class="form-label"><?php echo S1SC_LABEL_COMPANYOTHERINDIVIDUALS; ?></label>
                                        <input class="form-control" type="text" id="imonitor-report-supplier-other_individual" name="imonitor[report][supplier_otherindividuals]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3 mb-4">
                                        <label for="imonitor-report-supplier-additional_info" class="form-label"><?php echo S1SC_LABEL_COMPANYADDITIONALINFO; ?></label>
                                        <textarea class="form-control" id="imonitor-report-supplier-additional_info" name="imonitor[report][supplier_additionalinfo]"></textarea>

                                    </div>
                                </div>


                            </div>


                        </fieldset>


                    </div>
                </section>
                <section class="row">
                    <div class="col">
                        <fieldset>
                            <legend><span><?php echo GENERIC_LABEL_FILEUPLOAD; ?></span></legend>
                            <span class="help"><?php echo GENERIC_HELP_FILEUPLOAD; ?></span>




                            <div class="row mt-4" id="imonitor-files-wrapper-0" data-flat-name="imonitor[files]">
                                <div class="col">
                                    <input type="file" placeholder="<?php placeholderize(GENERIC_FIELD_FILENAME); ?>" id="imonitor-files-file-0" name="imonitor[files][0][file]" data-particle-name="file" data-flat-name="imonitor[files]" class="form-control">
                                </div>
                                <div class="col">
                                    <input type="text" placeholder="<?php placeholderize(GENERIC_FIELD_FILEDESCRIPTION); ?>" id="imonitor-files-label-0" name="imonitor[files][0][label]"  data-particle-name="label" data-flat-name="imonitor[files]" class="form-control">
                                </div>
                                <div class="col">
                                    <select class="form-control" id="imonitor-files-type-0" name="imonitor[files][0][type]" data-particle-name="type" data-flat-name="imonitor[files]">
                                        <option value="contract">Contract</option>
                                        <option value="contract">Extension</option>
                                        <option value="contract">Documents</option>
                                        <option value="contract">Images</option>
                                    </select>
                                </div>
                            </div>

                            <div class="btn-group" role="group" aria-label="group fields repeater">
                                <button class="btn btn-sm btn-outline-secondary repeater mt-2 mb-2" data-repeater-target="#imonitor-files-wrapper-0" type="button">
                                    <i class="fal fa-plus"></i> <?php echo GENERIC_BUTTON_ADDFILEUPLOAD; ?>
                                </button>
                            </div>
















                        </fieldset>
                    </div>
                </section>
            </div>

            <div class="tab-pane fade" id="contract-implementation-tab-pane" role="tabpanel" aria-labelledby="contract-implementation-tab" tabindex="1">
                <div class="monitutor">
                    <h5><?php echo S2_TITLE_TEXT; ?></h5>
                    <p><?php echo nl2br(S2_PARAGRAPH_TEXT); ?></p>
                </div>
                <section class="row">
                    <div class="col">
                        <fieldset>

                            <legend><span><?php echo S2SA_TITLE_TEXT;?></span></legend>

                            <div class="col mt-3 mb-4">
                                <label class="form-label d-block">
                                <?php echo S2SA_LABEL_SITEINSPECTION; ?>
                                </label>
                                <small class="help"><?php echo S2SA_HELP_SITEINSPECTION; ?></small>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input inspection-sites-trigger" data-target="#imonitor-report-inspection-sites-yes" type="radio" name="imonitor[report][site_inspection]" id="imonitor-report-site_inspection_yes" value="YES">
                                    <label class="form-check-label" for="imonitor-report-site_inspection_yes"><?php echo GENERIC_RADIOLABEL_YES; ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input  inspection-sites-trigger" data-target="#imonitor-report-inspection-sites-no" type="radio" name="imonitor[report][site_inspection]" id="imonitor-report-site_inspection_no" value="NO">
                                    <label class="form-check-label" for="imonitor-report-site_inspection_no"><?php echo GENERIC_RADIOLABEL_NO; ?></label>
                                </div>
                            </div>

                            <div class="col mt-3 mb-4 inspection-site-wrap d-none" id="imonitor-report-inspection-sites-yes">
                                <div class="form-label" id="imonitor-report-inspection"><?php echo S2SA_LABEL_SITEINSPECTED; ?></div>
                                <span class="help"><?php echo S2SA_HELP_SITEINSPECTED; ?></span>
                                <div class="row" id="imonitor-report-contract-inspection-0" data-flat-name="imonitor[report][inspection_site]">
                                    <div class="col">
                                        <select class="form-control inspection inspection-site" id="imonitor-report-contract-inspection-site-0" data-flat-name="imonitor[report][inspection_site]" data-particle-name="site" name="imonitor[report][inspection_site][0][site]" placeholder="inspection site..." aria-label="inspection site" aria-describedby="imonitor-report-inspection_site">
                                        </select>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <input type="date" class="form-control inspection inspection-date" id="imonitor-report-contract-inspection-date-0" data-flat-name="imonitor[report][inspection_site]" data-particle-name="date" name="imonitor[report][inspection_site][0][date]" placeholder="inspection date..." aria-label="inspection date" aria-describedby="imonitor-report-inspection">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary repeater mt-2 mb-2" data-repeater-target="#imonitor-report-contract-inspection-0" type="button"><i class="fal fa-plus"></i> <?php echo S2SA_BUTTON_ADDINSPECTION; ?></button>
                                <button class="btn btn-sm btn-outline-secondary update-inspection-sites mt-2 mb-2" id="update-inspection-sites" type="button"><i class="fal fa-recycle"></i> <?php echo S2SA_BUTTON_UPDATESITELIST; ?></button>
                            </div>


                            <div class="col mt-3 mb-4 inspection-site-wrap  d-none" id="imonitor-report-inspection-sites-no">
                                <div class="form-label"><?php echo S2SA_LABEL_INSPECTIONFAIL; ?></div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][inspection_fail_access_denied]" id="imonitor-report-inspection_fail_access_denied" value="1">
                                    <label class="form-check-label" for="imonitor-report-inspection_fail_access_denied"><?php echo S2SA_OPTION_INSPECTIONFAIL_1; ?></label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][inspection_fail_located]" id="imonitor-report-inspection_fail_located" value="1">
                                    <label class="form-check-label" for="imonitor-report-inspection_fail_located"><?php echo S2SA_OPTION_INSPECTIONFAIL_2; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][inspection_fail_resources]" id="imonitor-report-inspection_fail_resources" value="1">
                                    <label class="form-check-label" for="imonitor-report-inspection_fail_resources"><?php echo S2SA_OPTION_INSPECTIONFAIL_3; ?></label>
                                </div>
                                <div class="">
                                    <input class="form-control" type="text" name="imonitor[report][inspection_fail_other]" id="imonitor-report-inspection_fail_other" value="" placeholder="<?php placeholderize(GENERIC_LABEL_OTHER); ?>">
                                    <label class="form-label sr-only" for="imonitor-report-inspection_fail_other"><?php echo GENERIC_LABEL_OTHER; ?></label>
                                </div>
                            </div>



                            <div class="col mt-3 mb-4">
                                <div class="form-label"><?php echo S2SA_LABEL_IMPLEMENTATIONSTATUS; ?></div>
                                <div class="form-check">
                                    <input class="form-check-input status-dep-trigger" data-target="#imonitor-report-status-delay" type="radio" name="imonitor[report][implementation_status]" id="imonitor-report-implementation_status_1" value="1">
                                    <label class="form-check-label" for="imonitor-report-implementation_status_1">
                                        <?php echo S2SA_RADIOLABEL_IMPLEMENTATIONSTATUS_1; ?><br />
                                        <small><?php echo S2SA_HELP_IMPLEMENTATIONSTATUS_1; ?></small>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input status-dep-trigger" data-target="#imonitor-report-status-ongoing" type="radio" name="imonitor[report][implementation_status]" id="imonitor-report-implementation_status_2" value="2">
                                    <label class="form-check-label" for="imonitor-report-implementation_status_2">
                                        <?php echo S2SA_RADIOLABEL_IMPLEMENTATIONSTATUS_2; ?><br />
                                        <small><?php echo S2SA_HELP_IMPLEMENTATIONSTATUS_2; ?></small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input status-dep-trigger" data-target="#imonitor-report-status-complete" type="radio" name="imonitor[report][implementation_status]" id="imonitor-report-implementation_status_3" value="3">
                                    <label class="form-check-label" for="imonitor-report-implementation_status_3">
                                        <?php echo S2SA_RADIOLABEL_IMPLEMENTATIONSTATUS_3; ?><br />
                                        <small><?php echo S2SA_HELP_IMPLEMENTATIONSTATUS_3; ?></small>
                                    </label>
                                </div>
                            </div>

                            <!-- BOF Option A -->
                            <div class="col mt-3 mb-4 d-none status-dep" id="imonitor-report-status-delay">
                                <label for="imonitor-report-contract-delay-reason"><?php echo S2SA_LABEL_IMPLEMENTATIONSTATUSINFO; ?></label>
                                <input type="text" class="form-control" id="imonitor-report-contract-delay-reason" name="imonitor[report][contract_delay_reason]" placeholder="..." aria-label="Delay reasons" aria-describedby="imonitor-report-contract-delay-reason">
                            </div>
                            <!-- EOF OPTION A -->


                            <!-- BOF Option B - Ongoing -->
                            <div class="d-none status-dep" id="imonitor-report-status-ongoing">
                                <div class="col mt-3 mb-4">
                                    <div class="form-label"><?php echo S2SA_LABEL_IMPLEMENTATIONSCHEDULE; ?> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#imonitor-modal-contract-following-schedule"><i class="fal fa-question-circle"></i></button></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_following_schedule]" id="imonitor-report-contract_following_schedule_1" value="Yes">
                                        <label class="form-check-label" for="imonitor-report-contract_following_schedule_1"><?php echo GENERIC_RADIOLABEL_YES; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_following_schedule]" id="imonitor-report-contract_following_schedule_2" value="No">
                                        <label class="form-check-label" for="imonitor-report-contract_following_schedule_2"><?php echo GENERIC_RADIOLABEL_NO; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_following_schedule]" id="imonitor-report-contract_following_schedule_3" value="Unknown">
                                        <label class="form-check-label" for="imonitor-report-contract_following_schedule_3"><?php echo GENERIC_RADIOLABEL_UNKNOWN; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="imonitor-report-contract-following_schedule-reason"><?php echo GENERIC_LABEL_DETAILEDINFO; ?></label>
                                        <small class="help"><?php echo GENERIC_HELP_DETAILEDINFO; ?></small>
                                        <input type="text" class="form-control" id="imonitor-report-contract-following_schedule-reason" name="imonitor[report][contract_following_schedule_reason]" placeholder="..." aria-label="Delay reasons" aria-describedby="imonitor-report-contract-following_schedule-reason">
                                    </div>
                                </div>

                                <div class="col mt-3 mb-4">
                                    <div class="form-label"><?php echo S2SA_LABEL_QUANTITYQUALITY; ?> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#imonitor-modal-contract_quantity_quality"><i class="fal fa-question-circle"></i></button></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_quantity_quality]" id="imonitor-report-contract_quantity_quality_1" value="Yes">
                                        <label class="form-check-label" for="imonitor-report-contract_quantity_quality_1"><?php echo GENERIC_RADIOLABEL_YES; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_quantity_quality]" id="imonitor-report-contract_quantity_quality_2" value="No">
                                        <label class="form-check-label" for="imonitor-report-contract_quantity_quality_2"><?php echo GENERIC_RADIOLABEL_NO; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_quantity_quality]" id="imonitor-report-contract_quantity_quality_3" value="Unknown">
                                        <label class="form-check-label" for="imonitor-report-contract_quantity_quality_3"><?php echo GENERIC_RADIOLABEL_UNKNOWN; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="imonitor-report-contract_quantity_quality-reason"><?php echo GENERIC_LABEL_DETAILEDINFO; ?></label>
                                        <small class="help"><?php echo GENERIC_HELP_DETAILEDINFO; ?></small>
                                        <input type="text" class="form-control" id="imonitor-report-contract_quantity_quality-reason" name="imonitor[report][contract_quantity_quality_reason]" placeholder="..." aria-label="Delay reasons" aria-describedby="imonitor-report-contract-following_schedule-reason">
                                    </div>
                                </div>

                                <div class="col mt-3 mb-4">
                                    <div class="form-label"><?php echo S2SA_LABEL_PAYMENTS; ?> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#imonitor-modal-contract-payments"><i class="fal fa-question-circle"></i></button></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_payments]" id="imonitor-report-contract_payments_1" value="Yes">
                                        <label class="form-check-label" for="imonitor-report-contract_payments_1"><?php echo GENERIC_RADIOLABEL_YES; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_payments]" id="imonitor-report-contract_payments_2" value="No">
                                        <label class="form-check-label" for="imonitor-report-contract_payments_2"><?php echo GENERIC_RADIOLABEL_NO; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_payments]" id="imonitor-report-contract_payments_3" value="Unknown">
                                        <label class="form-check-label" for="imonitor-report-contract_payments_3"><?php echo GENERIC_RADIOLABEL_UNKNOWN; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="imonitor-report-contract_payments-reason"><?php echo GENERIC_LABEL_DETAILEDINFO; ?></label>
                                        <small class="help"><?php echo GENERIC_HELP_DETAILEDINFO; ?></small>
                                        <input type="text" class="form-control" id="imonitor-report-contract_payments-reason" name="imonitor[report][contract_payments_reason]" placeholder="..." aria-label="Delay reasons" aria-describedby="imonitor-report-contract-following_schedule-reason">
                                    </div>
                                </div>



                                <!-- Subconditional here -->
                                <div class="col mt-3 mb-4 d-none" id="contract-mdofications-on">
                                    <div class="form-label"><?php echo S2SA_LABEL_CONTRACTMODSINWRITING; ?><button type="button" class="btn btn-sm" data-toggle="modal" data-target="#imonitor-modal-contract_modifications_writing"><i class="fal fa-question-circle"></i></button></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_modifications_writing]" id="imonitor-report-contract_modifications_writing_1" value="Yes">
                                        <label class="form-check-label" for="imonitor-report-contract_following_schedule_1"><?php echo GENERIC_RADIOLABEL_YES; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_modifications_writing]" id="imonitor-report-contract_modifications_writing_2" value="No">
                                        <label class="form-check-label" for="imonitor-report-contract_modifications_writing_2"><?php echo GENERIC_RADIOLABEL_NO; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_modifications_writing]" id="imonitor-report-contract_modifications_writing_3" value="Unknown">
                                        <label class="form-check-label" for="imonitor-report-contract_modifications_writing_3"><?php echo GENERIC_RADIOLABEL_UNKNOWN; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="imonitor-report-contract_modifications_writing-reason"><?php echo GENERIC_LABEL_DETAILEDINFO; ?></label>
                                        <small class="help"><?php echo GENERIC_HELP_DETAILEDINFO; ?></small>
                                        <input type="text" class="form-control" id="imonitor-report-contract_modifications_writing-reason" name="imonitor[report][contract_modifications_writing_reason]" placeholder="..." aria-label="Delay reasons" aria-describedby="imonitor-report-contract-following_schedule-reason">
                                    </div>
                                </div>
                                <!-- EOF Subconditional -->


                                <div class="col mt-3 mb-4">
                                    <div class="form-label"><?php echo S2SA_LABEL_CONTRACTPROVISIONSFULFILLED; ?><button type="button" class="btn btn-sm" data-toggle="modal" data-target="#imonitor-modal-contract_provisions_fulfilled"><i class="fal fa-question-circle"></i></button></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_provisions_fulfilled]" id="imonitor-report-contract_provisions_fulfilled_1" value="Yes">
                                        <label class="form-check-label" for="imonitor-report-contract_provisions_fulfilled_1"><?php echo GENERIC_RADIOLABEL_YES; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_provisions_fulfilled]" id="imonitor-report-contract_provisions_fulfilled_2" value="No">
                                        <label class="form-check-label" for="imonitor-report-contract_provisions_fulfilled_2"><?php echo GENERIC_RADIOLABEL_NO; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_provisions_fulfilled]" id="imonitor-report-contract_provisions_fulfilled_3" value="Unknown">
                                        <label class="form-check-label" for="imonitor-report-contract_provisions_fulfilled_3"><?php echo GENERIC_RADIOLABEL_UNKNOWN; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="imonitor-report-contract_provisions_fulfilled-reason"><?php echo GENERIC_LABEL_DETAILEDINFO; ?></label>
                                        <small class="help"><?php echo GENERIC_HELP_DETAILEDINFO; ?></small>
                                        <input type="text" class="form-control" id="imonitor-report-contract_provisions_fulfilled-reason" name="imonitor[report][contract_provisions_fulfilled_reason]" placeholder="Delay reasons..." aria-label="Delay reasons" aria-describedby="imonitor-report-contract-following_schedule-reason">
                                    </div>
                                </div>
                            </div>
                            <!-- EOF OPTION B -->


                            <!-- BOF OPTION C _ Finished -->
                            <div class="d-none status-dep" id="imonitor-report-status-complete">
                                <div class="col mt-3 mb-4">
                                    <div class="form-label"><?php echo S2SA_LABEL_SUPPLIERDELIVER; ?>
                                        <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#imonitor-modal-contract_supplier_fully_deliver"><i class="fal fa-question-circle"></i></button>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_supplier_fully_deliver]" id="imonitor-report-contract_supplier_fully_deliver_1" value="Yes">
                                        <label class="form-check-label" for="imonitor-report-contract_supplier_fully_deliver_1"><?php echo GENERIC_RADIOLABEL_YES; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_supplier_fully_deliver]" id="imonitor-report-contract_supplier_fully_deliver_2" value="No">
                                        <label class="form-check-label" for="imonitor-report-contract_supplier_fully_deliver_2"><?php echo GENERIC_RADIOLABEL_NO; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_supplier_fully_deliver]" id="imonitor-report-contract_supplier_fully_deliver_3" value="Unknown">
                                        <label class="form-check-label" for="imonitor-report-contract_supplier_fully_deliver_3"><?php echo GENERIC_RADIOLABEL_UNKNOWN; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="imonitor-report-contract_supplier_fully_deliver-reason"><?php echo GENERIC_LABEL_DETAILEDINFO; ?></label>
                                        <small class="help"><?php echo GENERIC_HELP_DETAILEDINFO; ?></small>
                                        <input type="text" class="form-control" id="imonitor-report-contract_supplier_fully_deliver-reason" name="imonitor[report][contract_supplier_fully_deliver_reasons]" placeholder="..." aria-label="Delay reasons" aria-describedby="imonitor-report-contract-following_schedule-reason">
                                    </div>
                                </div>

                                <div class="col mt-3 mb-4">
                                    <div class="form-label"><?php echo S2SA_LABEL_DELIVEREDGOODS; ?>
                                        <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#imonitor-modal-contract_supply_acceptable_state"><i class="fal fa-question-circle"></i></button>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_supply_acceptable_state]" id="imonitor-report-contract_supply_acceptable_state_1" value="Yes">
                                        <label class="form-check-label" for="imonitor-report-contract_supply_acceptable_state_1"><?php echo GENERIC_RADIOLABEL_YES; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_supply_acceptable_state]" id="imonitor-report-contract_supply_acceptable_state_2" value="No">
                                        <label class="form-check-label" for="imonitor-report-contract_supply_acceptable_state_2"><?php echo GENERIC_RADIOLABEL_NO; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_supply_acceptable_state]" id="imonitor-report-contract_supply_acceptable_state_3" value="Unknown">
                                        <label class="form-check-label" for="imonitor-report-contract_supply_acceptable_state_3"><?php echo GENERIC_RADIOLABEL_UNKNOWN; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="imonitor-report-contract_supply_acceptable_state-reason"><?php echo GENERIC_LABEL_DETAILEDINFO; ?></label>
                                        <small class="help"><?php echo GENERIC_HELP_DETAILEDINFO; ?></small>
                                        <input type="text" class="form-control" id="imonitor-report-contract_supply_acceptable_state-reason" name="imonitor[report][contract_supply_acceptable_reason]" placeholder="..." aria-label="Delay reasons" aria-describedby="imonitor-report-contract-following_schedule-reason">
                                    </div>
                                </div>

                                <div class="col mt-3 mb-4">
                                    <div class="form-label"><?php echo S2SA_LABEL_PROCUREDGOODS; ?></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_procured_goods_intended]" id="imonitor-report-contract_procured_goods_intended_1" value="Yes">
                                        <label class="form-check-label" for="imonitor-report-contract_procured_goods_intended_1"><?php echo GENERIC_RADIOLABEL_YES; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_procured_goods_intended]" id="imonitor-report-contract_procured_goods_intended_2" value="No">
                                        <label class="form-check-label" for="imonitor-report-contract_procured_goods_intended_2"><?php echo GENERIC_RADIOLABEL_NO; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_procured_goods_intended]" id="imonitor-report-contract_procured_goods_intended_3" value="Unknown">
                                        <label class="form-check-label" for="imonitor-report-contract_procured_goods_intended_3"><?php echo GENERIC_RADIOLABEL_UNKNOWN; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="imonitor-report-contract_procured_goods_intended-reason"><?php echo GENERIC_LABEL_DETAILEDINFO; ?></label>
                                        <small class="help"><?php echo GENERIC_HELP_DETAILEDINFO; ?></small>
                                        <input type="text" class="form-control" id="imonitor-report-contract_procured_goods_intended-reason" name="imonitor[report][contract_procured_goods_intended_reason]" placeholder="..." aria-label="Delay reasons" aria-describedby="imonitor-report-contract-following_schedule-reason">
                                    </div>
                                </div>





                                <div class="col mt-3 mb-4">
                                    <div class="form-label"><?php echo S2SA_LABEL_WORKSCONTRACT; ?></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_works_project_operational]" id="imonitor-report-contract_works_project_operational_1" value="Yes">
                                        <label class="form-check-label" for="imonitor-report-contract_works_project_operational_1"><?php echo GENERIC_RADIOLABEL_YES; ?></label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_works_project_operational]" id="imonitor-report-contract_works_project_operational_2" value="No">
                                        <label class="form-check-label" for="imonitor-report-contract_works_project_operational_2"><?php echo GENERIC_RADIOLABEL_NO; ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imonitor[report][contract_works_project_operational]" id="imonitor-report-contract_works_project_operational_3" value="Unknown">
                                        <label class="form-check-label" for="imonitor-report-contract_works_project_operational_3"><?php echo GENERIC_RADIOLABEL_UNKNOWN; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="imonitor-report-contract_works_project_operational-reason"><?php echo GENERIC_LABEL_DETAILEDINFO; ?></label>
                                        <small class="help"><?php echo GENERIC_HELP_DETAILEDINFO; ?></small>
                                        <input type="text" class="form-control" id="imonitor-report-contract_works_project_operational-reason" name="imonitor[report][contract_works_project_operational_reason]" placeholder="..." aria-label="Delay reasons" aria-describedby="imonitor-report-contract-following_schedule-reason">
                                    </div>
                                </div>
                            </div>
                            <!--EOF OPTION C - FINISHED -->


                            <div class="col mt-3 mb-4">
                                <label for="imonitor-report-contract_implementation_additional_information"><?php echo S2SA_LABEL_ADDITIONALINFO; ?></label>
                                <input type="text" class="form-control" id="imonitor-report-contract_implementation_additional_information" name="imonitor[report][contract_implementation_additional_information]" placeholder="<?php placeholderize(S2SA_LABEL_ADDITIONALINFO); ?>" aria-label="Additional information" aria-describedby="imonitor-report-contract-following_schedule-reason">
                            </div>





                        </fieldset>

                        <fieldset>
                            <legend><span><?php echo S2SB_TITLE_TEXT; ?></span></legend>

                            <div class="col mt-3 mb-4">
                                <span class="form-label d-block"><?php echo S2SB_LABEL_SOURCES; ?></span>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][contract_investigation_webresearch]" id="imonitor-report-contract_investigation_webresearch" value="1">
                                    <label class="form-check-label" for="imonitor-report-contract_investigation_webresearch"><?php echo S2SB_LABEL_SOURCES_WEB; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][contract_investigation_documentation]" id="imonitor-report-contract_investigation_documentation" value="1">
                                    <label class="form-check-label" for="imonitor-report-contract_investigation_documentation"><?php echo S2SB_LABEL_SOURCES_DOCS; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][contract_investigation_inspection]" id="imonitor-report-contract_investigation_inspection" value="1">
                                    <label class="form-check-label" for="imonitor-report-contract_investigation_inspection"><?php echo S2SB_LABEL_SOURCES_SITE; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][contract_investigation_interviewcontracting]" id="imonitor-report-contract_investigation_interviewcontracting" value="1">
                                    <label class="form-check-label" for="imonitor-report-contract_investigation_interviewcontracting"><?php echo S2SB_LABEL_SOURCES_INTERVIEW_REPS; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][contract_investigation_webresearch]" id="imonitor-report-contract_investigation_interviewsupervisor" value="1">
                                    <label class="form-check-label" for="imonitor-report-contract_investigation_interviewsupervisor"><?php echo S2SB_LABEL_SOURCES_INTERVIEW_SUPERVISOR; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][contract_investigation_interviewresponsible]" id="imonitor-report-contract_investigation_interviewresponsible" value="1">
                                    <label class="form-check-label" for="imonitor-report-contract_investigation_interviewresponsible"><?php echo S2SB_LABEL_SOURCES_INTERVIEW_RCI; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][contract_investigation_interviewbeneficiaries]" id="imonitor-report-contract_investigation_interviewbeneficiaries" value="1">
                                    <label class="form-check-label" for="imonitor-report-contract_investigation_interviewbeneficiaries"><?php echo S2SB_LABEL_SOURCES_BENEFICIARIES; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][contract_investigation_interviewother]" id="imonitor-report-contract_investigation_interviewother" value="1">
                                    <label class="form-check-label" for="imonitor-report-contract_investigation_interviewother"><?php echo S2SB_LABEL_SOURCES_OTHER; ?></label>
                                </div>

                                <div class="">
                                    <label class="form-label" for="imonitor-report-contract_investigation_other"><?php echo GENERIC_LABEL_OTHER; ?></label>
                                    <input class="form-control" type="text" name="imonitor[report][contract_investigation_other]" id="imonitor-report-contract_investigation_other">
                                </div>
                            </div>


                            <div class="col mt-3 mb-4">
                                <span class="form-label d-block"><?php echo S2SB_LABEL_DOCUMENTATIONACCESS; ?></span>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th><?php echo GENERIC_RADIOLABEL_YES; ?></th>
                                        <th><?php echo GENERIC_RADIOLABEL_NO; ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><span class="form-label"><?php echo S2SB_OPTION_DOCUMENTATIONACCESS_1; ?></span></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="imonitor[report][contract_doctype_access_contract]" id="imonitor-report-contract_doctype_access_contract" value="Yes">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="imonitor[report][contract_doctype_access_contract]" id="imonitor-report-contract_doctype_access_contract" value="NO">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="form-label"><?php echo S2SB_OPTION_DOCUMENTATIONACCESS_2; ?></span></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="imonitor[report][contract_doctype_access_contract_ext]" id="imonitor-report-contract_doctype_access_contract_ext" value="YES">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="imonitor[report][contract_doctype_access_contract_ext]" id="imonitor-report-contract_doctype_access_contract_ext" value="NO">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="form-label"><?php echo S2SB_OPTION_DOCUMENTATIONACCESS_3; ?></span></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="imonitor[report][contract_doctype_access_contract_reports]" id="imonitor-report-contract_doctype_access_contract_reports" value="YES">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="imonitor[report][contract_doctype_access_contract_reports]" id="imonitor-report-contract_doctype_access_contract_reports" value="NO">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="form-label"><?php echo S2SB_OPTION_DOCUMENTATIONACCESS_4; ?></span></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="imonitor[report][contract_doctype_access_pos_invoices]" id="imonitor-report-contract_doctype_access_pos_invoices" value="YES">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="imonitor[report][contract_doctype_access_pos_invoices]" id="imonitor-report-contract_doctype_access_pos_invoices" value="NO">
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><span class="form-label"><?php echo S2SB_OPTION_DOCUMENTATIONACCESS_5; ?></span></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="imonitor[report][contract_doctype_access_technical]" id="imonitor-report-contract_doctype_access_technical" value="YES">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="imonitor[report][contract_doctype_access_technical]" id="imonitor-report-contract_doctype_access_technical" value="NO">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="form-label"><?php echo S2SB_OPTION_DOCUMENTATIONACCESS_6; ?></span></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="imonitor[report][contract_doctype_access_bid]" id="imonitor-report-contract_doctype_access_bid" value="YES">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="imonitor[report][contract_doctype_access_bid]" id="imonitor-report-contract_doctype_access_bid" value="NO">
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="col mt-3 mb-4">
                                <span class="form-label d-block"><?php echo S2SB_LABEL_DOCUMENTATIONACCESSFAIL; ?></span>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][contract_doctype_access_problem_incomplete]" id="imonitor-report-contract_doctype_access_problem_incomplete" value="1">
                                    <label class="form-check-label" for="imonitor-report-contract_doctype_access_problem_incomplete"><?php echo S2SB_OPTION_DOCUMENTATIONACCESSFAIL_1; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][contract_doctype_access_problem_not_obtained]" id="imonitor-report-contract_doctype_access_problem_not_obtained" value="1">
                                    <label class="form-check-label" for="imonitor-report-contract_doctype_access_problem_not_obtained"><?php echo S2SB_OPTION_DOCUMENTATIONACCESSFAIL_2; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][contract_doctype_access_problem_not_granted]" id="imonitor-report-contract_doctype_access_problem_not_granted" value="1">
                                    <label class="form-check-label" for="imonitor-report-contract_doctype_access_problem_not_granted"><?php echo S2SB_OPTION_DOCUMENTATIONACCESSFAIL_3; ?></label>
                                </div>
                                <div class="">
                                    <label class="form-label" for="imonitor-report-contract_doctype_access_problem_other"><?php echo GENERIC_LABEL_OTHER; ?></label>
                                    <input class="form-control" type="text" name="imonitor[report][contract_doctype_access_problem_other]" id="imonitor-report-contract_doctype_access_problem_other">
                                </div>

                            </div>

                            <div class="col mt-3 mb-4">
                                <span class="form-label d-block"><?php echo S2SB_LABEL_INTERVIEWS; ?></span>
                                <span class="help"><?php echo S2SB_HELP_INTERVIEWS; ?></span>
                                <div class="row mb-3" id="imonitor-report-contract-interviewed-0" data-flat-name="imonitor[report][contract_interviewed]">
                                    <div class="col-6">
                                        <label class="form-label sr-only" for="imonitor-report-contract-interviewedname-0"><?php echo S2SB_TEXT_INTERVIEWNAME; ?></label>
                                        <input type="text" id="imonitor-report-contract-interviewedname-0" class="form-control" name="imonitor[report][contract_interviewed][0][name]" data-flat-name="imonitor[report][contract_interviewed]" data-particle-name="name" placeholder="<?php echo S2SB_TEXT_INTERVIEWNAME; ?>">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label sr-only" for="imonitor-report-contract-interviewedrole-0"><?php echo S2SB_TEXT_INTERVIEWROLE; ?></label>
                                        <input type="text" id="imonitor-report-contract-interviewedrole-0" class="form-control" name="imonitor[report][contract_interviewed][0][role]" data-flat-name="imonitor[report][contract_interviewed]" data-particle-name="role" placeholder="<?php echo S2SB_TEXT_INTERVIEWROLE; ?>">
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary repeater mt-2 mb-2" data-repeater-target="#imonitor-report-contract-interviewed-0" type="button"><i class="fal fa-plus"></i> <?php echo S2SB_BUTTON_ADDINTERVIEW; ?></button>
                            </div>
                            <div class="col mb-4 mt-3 ">
                                <label for="imonitor-report-contract_online_sources"><?php echo S2SB_LABEL_ONLINESOURCES; ?></label>
                                <input type="text" class="form-control" id="imonitor-report-contract_online_sources" name="imonitor[report][contract_online_sources]" placeholder="..." aria-label="Online sources" aria-describedby="imonitor-report-contract_online_sources">

                            </div>
                        </fieldset>
                    </div>
                </section>




            </div>

            <div class="tab-pane fade" id="results-and-impact-tab-pane" role="tabpanel" aria-labelledby="results-and-impact-tab" tab-index="2">
                <div class="monitutor">
                    <h5><?php echo S3_TITLE_LABEL; ?> - <?php echo S3_TITLE_TEXT; ?></h5>
                </div>
                <section class="row">
                    <div class="col">
                        <fieldset>
                            <legend><span><?php echo S3S_TITLE_CONNECTIONS; ?></span></legend>
                            <div class="col mt-3 mb-4">
                                <label class="form-label d-block">
                                    <?php echo S3S_LABEL_CONNECTIONS; ?>
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][dissemination_x]" id="imonitor-report-dissemination_x" value="YES">
                                    <label class="form-check-label" for="imonitor-report-dissemination_x"><?php echo S3S_OPTION_CONNECTIONS_1; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][dissemination_facebook]" id="imonitor-report-dissemination_facebook" value="YES">
                                    <label class="form-check-label" for="imonitor-report-dissemination_facebook"><?php echo S3S_OPTION_CONNECTIONS_2; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][dissemination_instagram]" id="imonitor-report-dissemination_instagram" value="YES">
                                    <label class="form-check-label" for="imonitor-report-dissemination_instagram"><?php echo S3S_OPTION_CONNECTIONS_3; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][dissemination_events]" id="imonitor-report-dissemination_events" value="YES">
                                    <label class="form-check-label" for="imonitor-report-dissemination_events"><?php echo S3S_OPTION_CONNECTIONS_4; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][dissemination_website]" id="imonitor-report-dissemination_website" value="YES">
                                    <label class="form-check-label" for="imonitor-report-dissemination_website"><?php echo S3S_OPTION_CONNECTIONS_5; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][dissemination_offline]" id="imonitor-report-dissemination_offline" value="YES">
                                    <label class="form-check-label" for="imonitor-report-dissemination_offline"><?php echo S3S_OPTION_CONNECTIONS_6; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][dissemination_meetings]" id="imonitor-report-dissemination_meetings" value="YES">
                                    <label class="form-check-label" for="imonitor-report-dissemination_meetings"><?php echo S3S_OPTION_CONNECTIONS_7; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][dissemination_media]" id="imonitor-report-dissemination_media" value="YES">
                                    <label class="form-check-label" for="imonitor-report-dissemination_media"><?php echo S3S_OPTION_CONNECTIONS_8; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][dissemination_other]" id="imonitor-report-dissemination_other" value="YES">
                                    <label class="form-check-label" for="imonitor-report-dissemination_other"><?php echo GENERIC_LABEL_OTHER; ?></label>
                                </div>
                            </div>


                            <div id="connections-people" class="mt-3 mb-4">
                                <div class="form-label"><?php echo S3S_LABEL_CONNECTION_PERSON; ?></div>

                                <div class="row" id="imonitor-report-contract-connectionspeople-0" data-flat-name="imonitor[report][connectionsubject]">
                                    <div class="col">
                                        <input type="text" class="form-control connectionsubject connectionsubject-name" id="imonitor-report-contract-connectionsubject-name-0" data-flat-name="imonitor[report][connectionsubject]" data-particle-name="name" name="imonitor[report][connectionsubject][0][name]" placeholder="<?php placeholderize(S3S_LABEL_CONNECTION_PERSON_NAME); ?>" aria-label="Subcontractor name" aria-describedby="imonitor-report-subcontractor">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control connectionsubject connectionsubject-role" id="imonitor-report-contract-connectionsubject-role-0" data-flat-name="imonitor[report][connectionsubject]" data-particle-name="role" name="imonitor[report][connectionsubject][0][role]" placeholder="<?php placeholderize(S3S_LABEL_CONNECTION_PERSON_ROLE); ?>" aria-label="Subcontract value" aria-describedby="imonitor-report-subcontractor">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control connectionsubject connectionsubject-org" id="imonitor-report-contract-connectionsubject-org-0" data-flat-name="imonitor[report][connectionsubject]" data-particle-name="org" name="imonitor[report][connectionsubject][0][org]" placeholder="<?php placeholderize(S3S_LABEL_CONNECTION_PERSON_ORG); ?>" aria-label="Subcontract value" aria-describedby="imonitor-report-subcontractor">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control connectionsubject connectionsubject-connectiontype" id="imonitor-report-contract-connectionsubject-connectiontype-0" data-flat-name="imonitor[report][connectionsubject]" data-particle-name="connectiontype" name="imonitor[report][connectionsubject][0][connectiontype]" placeholder="<?php placeholderize(S3S_LABEL_CONNECTION_PERSON_TYPE); ?>" aria-label="Subcontract value" aria-describedby="imonitor-report-subcontractor">
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary repeater mt-2 mb-2" data-repeater-target="#imonitor-report-contract-connectionspeople-0" type="button"><i class="fal fa-plus"></i> <?php echo S3S_BUTTON_ADDCONNECTION; ?></button>
                            </div>

                            <div class="col mt-3 mb-4">
                                <div class="form-label"><?php echo S3S_LABEL_MEDIA; ?>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input trigger-display show-dependency" data-target="#shot-by-media" type="radio" name="imonitor[report][media_dissemination]" id="imonitor-report-media-dissemination_1" value="yes">
                                    <label class="form-check-label" for="imonitor-report-media-dissemination_1"><?php echo GENERIC_RADIOLABEL_YES; ?></label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input trigger-display" data-target="#shot-by-media" type="radio" name="imonitor[report][media_dissemination]" id="imonitor-report-media-dissemination_2" value="no">
                                    <label class="form-check-label" for="imonitor-report-media-dissemination_2"><?php echo GENERIC_RADIOLABEL_NO; ?></label>
                                </div>
                            </div>

                            <div class="col mt-3 mb-4 d-none" id="shot-by-media">
                                <label class="form-label d-block">
                                    <?php echo S3S_LABEL_WHICHMEDIA; ?>
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][shot_by_media_localtv]" id="imonitor-report-shot-by-media-localtv" value="YES">
                                    <label class="form-check-label" for="imonitor-report-shot-by-media-localtv"><?php echo S3S_OPTION_WHICHMEDIA_1; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][shot_by_media_nationaltv]" id="imonitor-report-shot-by-media-nationaltv" value="YES">
                                    <label class="form-check-label" for="imonitor-report-shot-by-media-nationaltv"><?php echo S3S_OPTION_WHICHMEDIA_2; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][shot_by_media_localpaper]" id="imonitor-report-shot-by-media-localpaper" value="YES">
                                    <label class="form-check-label" for="imonitor-report-shot-by-media-localpaper"><?php echo S3S_OPTION_WHICHMEDIA_3; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][shot_by_media_nationalpaper]" id="imonitor-report-shot-by-media-nationalpaper" value="YES">
                                    <label class="form-check-label" for="imonitor-report-shot-by-media-nationalpaper"><?php echo S3S_OPTION_WHICHMEDIA_4; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][shot_by_media_online]" id="imonitor-report-shot-by-media-online" value="YES">
                                    <label class="form-check-label" for="imonitor-report-shot-by-media-online"><?php echo S3S_OPTION_WHICHMEDIA_5; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imonitor[report][shot_by_media_other]" id="imonitor-report-shot-by-media-other" value="YES">
                                    <label class="form-check-label" for="imonitor-report-shot-by-media-other"><?php echo GENERIC_LABEL_OTHER; ?></label>
                                </div>
                            </div>


                            <div class="col mt-3 mb-4">
                                <div class="form-label"><?php echo S3S_LABEL_CONTACTWITHADMINISTRATION; ?></div>
                                <div class="form-check">
                                    <input class="form-check-input trigger-display show-dependency" data-target="#public-admin-response" type="radio" name="imonitor[report][contact_public_admin]" id="imonitor-report-contact-public-admin_yes" value="yes">
                                    <label class="form-check-label" for="imonitor-report-contact-public-admin_yes"><?php echo GENERIC_RADIOLABEL_YES; ?></label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input trigger-display" data-target="#public-admin-response" type="radio" name="imonitor[report][contact_public_admin]" id="imonitor-report-contact-public-admin_no" value="no">
                                    <label class="form-check-label" for="imonitor-report-contact-public-admin_no"><?php echo GENERIC_RADIOLABEL_NO; ?></label>
                                </div>
                            </div>


                            <div class="col mt-3 mb-4 d-none" id="public-admin-response">
                                <label class="form-label d-block">
                                    <?php echo S3S_LABEL_ADMINISTRATIONQUESTIONS; ?>
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="imonitor[report][public_admin_response]" id="imonitor-report-public-admin-response-no" value="1">
                                    <label class="form-check-label" for="imonitor-report-public-admin-response-no"><?php echo S3S_OPTION_ADMINISTRATIONQUESTIONS_1; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="imonitor[report][public_admin_response]" id="imonitor-report-public-admin-response-some" value="2">
                                    <label class="form-check-label" for="imonitor-report-public-admin-response-some"><?php echo S3S_OPTION_ADMINISTRATIONQUESTIONS_2; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="imonitor[report][public_admin_response]" id="imonitor-report-public-admin-response-formal" value="3">
                                    <label class="form-check-label" for="imonitor-report-public-admin-response-formal"><?php echo S3S_OPTION_ADMINISTRATIONQUESTIONS_3; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="imonitor[report][public_admin_response]" id="imonitor-report-public-admin-response-concrete" value="4">
                                    <label class="form-check-label" for="imonitor-report-public-admin-response-concrete"><?php echo S3S_OPTION_ADMINISTRATIONQUESTIONS_4; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="imonitor[report][public_admin_response]" id="imonitor-report-public-admin-response-intopractice" value="5">
                                    <label class="form-check-label" for="imonitor-report-public-admin-response-intopractice"><?php echo S3S_OPTION_ADMINISTRATIONQUESTIONS_5; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="imonitor[report][public_admin_response]" id="imonitor-report-public-admin-response-fix" value="6">
                                    <label class="form-check-label" for="imonitor-report-public-admin-response-fix"><?php echo S3S_OPTION_ADMINISTRATIONQUESTIONS_6; ?></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="imonitor[report][public_admin_response]" id="imonitor-report-public-admin-response-other" value="7">
                                    <label class="form-check-label" for="imonitor-report-public-admin-response-other"><?php echo GENERIC_LABEL_OTHER; ?></label>
                                </div>
                            </div>


                            <div class="col mt-3 mb-4">
                                <label for="imonitor-report-result-description" class="form-label"><?php echo S3S_LABEL_CASEDESCRIPTION; ?></label>
                                <textarea class="form-control" id="imonitor-report-result-description" name="imonitor[report][case_description]"></textarea>
                            </div>
                        </fieldset>
                    </div>
                </section>
            </div>

        </main>

        <div class="row">
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="imonitor[report][status]" id="imonitor-report-status" value="<?php echo PENDING_REVIEW; ?>>">
                    <label class="form-check-label" for="imonitor-report-status">INVIA ALLA REDAZIONE PER LA REVISIONE</label>
                </div>
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-floppy-o"></i> SAVE</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5"></div>
        <div class="col-md-2" style="padding-top: 40px;">
            <img src="/images/eu_imonitor_logo_it.png" class="img-fluid" alt="EU Funded Logo">
        </div>
    </div>
</form>

<?php include('_partials/_modals.php'); ?>

