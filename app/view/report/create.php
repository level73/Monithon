<div class="container">
  <div class="row">
    <div class="col">
      <h1>Nuovo Report</h1>
      <form class="">
        <div class="form-group">
            <label for="oc_api_code" class="sr-only">Codice Univoco OpenCoesione:</label>
            <div class="input-group">
              <input type="text" name="oc_api_code" id="oc_api_code" placeholder="Codice univoco..." class="form-control">
              <div class="input-group-append">
                <button class="btn btn-primary" id="oc_api_code_lookup" type="button"><i class="fal fa-search"></i></button>
              </div>
            </div>
            <div class="invisible" id="oc_api_content">
              <i class="fal fa-sync fa-spin"></i>
            </div>
        </div>

      </form>

    </div>
  </div>
</div>
