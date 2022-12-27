</main>
<footer class="container-fluid " id="main-footer">

  <div class="row">
    <div class="col-4 col-md-2">
      Monithon 2016 - <?php echo strftime('%Y', time()); ?><br />
      <!-- <a href="https://level73.it">WITH HELP FROM <img src="https://style.level73.it/assets/images/lvl73-badge.png" alt="LEVEL73" width="15"></a> -->
    </div>
      <div class="col-4 col-md-2">
          <h4>MONITHON</h4>
          <ul class="list-unstyled">
              <li><a href="/">Area di Lavoro</a></li>
              <li><a href="https://projectfinder.monithon.eu">Project Finder</a></li>
              <li><a href="/report">Report (Lista)</a></li>
              <li><a href="https://reports.monithon.eu">Report (Mappa)</a></li>
              <?php if(isset($logged) && $logged == true){ ?>
                  <li><a href="/report/create">Crea Report</a></li>
              <?php } ?>
          </ul>
      </div>
    <div class="col-4 col-md-2">
      <h4>A PROPOSITO</h4>
      <ul class="list-unstyled">
        <li><a href="https://www.monithon.eu/about-ITA/" target="_blank">Chi siamo</a></li>
        <li><a href="/main/privacy">Privacy Policy</a></li>
        <li><a href="#">Credits</a></li>
      </ul>
    </div>
    <div class="col-3"></div>
    <div class="col-3">

    </div>
  </div>
</footer>
