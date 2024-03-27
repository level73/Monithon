
      <!-- Load JS -->
      <script src="/public/js/vendor/jquery.min.js"></script>
      <script src="/public/js/vendor/popper.min.js"></script>
      <script src="/public/js/vendor/bootstrap.min.js"></script>
      <script src="/public/js/vendor/bootstrap-select.min.js"></script>
      <script src="/public/js/vendor/bootstrap-table.min.js"></script>
      <script src="/public/js/main.min.js?v3.7.0"></script>
      <?php if( isset($street_map) ){
          if( $street_map === true ):
          ?>
      <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
              integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
              crossorigin="">
      </script>
      <?php
        elseif (is_array($street_map)):
            echo '
            <script src="https://unpkg.com/leaflet@' .  $street_map['version'] . '/dist/leaflet.js"
              integrity="' . $street_map['sha'] . '"
              crossorigin="">
      </script>';
        endif;
      }
      ?>
      <?php if(isset($charts) && !empty($charts)){ ?>
          <script src="<?php echo $charts; ?>"></script>
      <?php } ?>
      <?php loadJS($js); ?>
    </div>
  </body>
</html>
