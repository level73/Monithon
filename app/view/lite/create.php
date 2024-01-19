<div class="container">
    <div class="row">
        <div class="col">
            <h1>Nuovo Report
                <a class="btn btn-primary float-right" target="_blank" href="https://www.monithon.it/blog/2020/04/24/come-inviare-il-report-di-monitoraggio-tutti-i-nostri-suggerimenti/"><i class="fas fa-info-square"></i> GUIDA ALLA COMPILAZIONE</a>
            </h1>

            <form class="" method="post" enctype="multipart/form-data" action="/lite/create">
                <fieldset>
                    <legend>DATI SUL PROGETTO</legend>

                    <div class="form-group">
                        <label for="oc_api_code">URL del progetto monitorato:</label>
                        <small class="form-text text-muted">Per generare la MoniTutor, incolla qui l'indirizzo (URL) della pagina di OpenCoesione dedicata al singolo progetto che hai scelto di monitorare. Esempio: https://opencoesione.gov.it/it/progetti/1ca1c272007it161po009/</small>
                        <small class="form-text text-muted">Se il progetto che vuoi monitorare non è su OpenCoesione, inserisci il link della pagina di progetto (se disponibile). Ad esempio, OpenCUP. <br /><strong>N.B.</strong> Questo non genererà la MoniTutor.</small>
                        <div class="input-group">
                            <?php
                            if(isset($pfurl)){
                                if(isset($ref) && $ref == 's24'){
                                    ?>
                                    <input type="text" name="project_url" id="opencup" placeholder="URL del progetto scelto..." class="form-control pfurl" value="https://opencup.gov.it/portale/progetto/-/cup/<?php echo $pfurl; ?>">
                                    <?php
                                } else {
                                    ?>
                                    <input type="text" name="project_url" id="oc_api_code" placeholder="URL del progetto scelto..." class="form-control pfurl" value="<?php echo $pfurl; ?>">
                                    <?php
                                }
                            } else {
                                ?>
                                <input type="text" name="project_url" id="oc_api_code" placeholder="URL del progetto scelto..." class="form-control" value="<?php echo ckv($data, 'project_url'); ?>">
                            <?php } ?>
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="oc_api_code_lookup" type="button"><i class="fal fa-search"></i></button>
                            </div>
                            <input type="hidden" name="api_data" id="oc_data" value="">
                            <input type="hidden" name="project_code" id="project_code" value="">
                        </div>
                        <div class="d-none" id="oc_api_content_s1">
                            <i class="fal fa-sync fa-spin"></i>
                        </div>

                    </div>
                </fieldset>

            </form>

        </div>
    </div>
</div>