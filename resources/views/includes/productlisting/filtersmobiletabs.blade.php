<div class="d-md-none d-block sticky-mob-filter">
  <div class="d-flex">
    <div class="filter-head">
      <h4 class="mt-0">Filters</h4>
      <!-- <p class="filter-head__caption"><span id="filter_head_count">@{{filter_count}}</span> Filters Applied</p> -->
    </div>
    <div class="ml-auto"> <h3 id="kss_hide-filter" class="m-0 kss_highlight btn-pay"><span aria-hidden="true">&times;</span></h3></div>
  </div>
</div>

<ul class="nav flex-column kss_filter_mobile--left">
  @foreach($filters_arr as $filter)
    @include('includes.productlisting.productfilters.common.filtermobileheader', ['filter' => $filter])
  @endforeach
<!--   <li class="nav-item" data-target="category">
    Category
    <small class="filter-count">1</small>
  </li> -->
  <!-- <li class="nav-item" data-target="gender">
    Gender
  </li>
  <li class="nav-item" data-target="age">
    Age Group
  </li>
  <li class="nav-item" data-target="subtype">
    Sub Type
  </li>
  <li class="nav-item" data-target="price">
    Price Range
  </li>
  <li class="nav-item" data-target="color">
    Colour
  </li>
  <li class="nav-item" data-target="availability">
    Availability
  </li> -->
</ul>