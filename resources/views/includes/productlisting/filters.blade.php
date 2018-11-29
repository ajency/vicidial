<div class="col-sm-12 col-md-3">
  <div id="accordion" class="kss_filter d-sm-block">
    <div class="d-flex">
      <?php
        $filters_arr = json_decode(json_encode($filters),true);
        usort($filters_arr, function($a, $b) {
              return $a["order"] > $b["order"] ? 1 : -1;
          });
        // dd($filters_arr);
        ?>
      @include('includes.productlisting.filtersmobiletabs', ['filters_arr' => $filters_arr])

      @include('includes.productlisting.filtersrhs', ['filters_arr' => $filters_arr])

    <div class="fixed-bottom d-none footer-filter">
      <div class="row no-gutters">
          <!-- <div class="col-6 text-center d-flex">
            <button type="button" class="btn kss-btn kss-btn--big kss-btn--link">Reset</button>
          </div> -->
          <div class="col-12 text-center d-flex">
              <button type="button" id="kss_hide-filter" class="btn kss-btn kss-btn--big">Close</button>
          </div>
      </div>
    </div>
  </div>
</div>