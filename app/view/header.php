<header class="container-fluid" id="main-header">
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="https://www.monithon.eu" style="max-width: 80px;">
      <img src="/images/monithon-logo-2022.png" class="img-fluid" alt="Monithon Logo" title="Monithon" />
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"><i class="fal fa-bars"></i></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="/main">Home <span class="sr-only">(current)</span></a>
        </li>
          <li class="nav-item">
              <a class="nav-link" href="https://projectfinder.monithon.eu" target="_blank">Cerca un progetto</a>
          </li>

          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="reportDD" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  I Report
              </a>
              <div class="dropdown-menu" aria-labelledby="reportDD">
                  <a class="dropdown-item" href="/report">Lista</a>
                  <a class="dropdown-item" href="https://reports.monithon.eu" target="_blank">Mappa</a>
              </div>
          </li>

        <?php if(isset($logged) && $logged == true){ ?>
          <li class="nav-item">
            <a class="nav-link" href="/report/create">Crea Report</a>
          </li>
        <?php } ?>
      </ul>
      <!-- <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form> -->
      <?php
      if(isset($logged) && $logged == true) {
        include('_partials/user_menu.php');
      } else {
        include('_partials/user_login.php');
      }
      ?>

    </div>
  </nav>

</header>
<main class="flex-fill">
