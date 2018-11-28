<div class="col-sm-12 col-md-3">
  <div id="accordion" class="kss_filter d-sm-block">
    <div class="d-flex">

      @include('includes.productlisting.filtersmobiletabs', ['filters' => $params->filters])

      @include('includes.productlisting.filtersrhs', ['filters' => $params->filters])

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