<header class="container-fluid" id="main-header">
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="/">
      <img src="/images/monithon-logo.png" alt="Monithon Logo" title="Monithon" />
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"><i class="fal fa-bars"></i></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/report">I Report</a>
        </li>
        <?php if(isset($logged) && $logged == true){ ?>
          <li class="nav-item">
            <a class="nav-link" href="/report/create">Nuovo Report</a>
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
