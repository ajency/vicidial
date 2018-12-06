<div class="d-md-none d-block sticky-mob-filter">
  <div class="d-flex">
    <div class="filter-head">
      <h4 class="mt-0">Filters</h4>
    </div>
    <div class="ml-auto"> <h3 id="kss_hide-filter" class="m-0 kss_highlight btn-pay"><span aria-hidden="true">&times;</span></h3></div>
  </div>
</div>

<ul class="nav flex-column kss_filter_mobile--left">
  @foreach($filters_arr as $filter)
    @include('includes.productlisting.productfilters.common.filtermobileheader', ['filter' => $filter])
  @endforeach
</ul>