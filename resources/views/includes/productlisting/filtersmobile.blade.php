<div class="modal fade" id="kss_sort" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog m-0 fixed-bottom" role="document">
        <div class="modal-content fixed-bottom">
          <div class="modal-header">
            <h6 class="modal-title text-muted" id="exampleModalLongTitle">Sort by</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="">
            <ul class="list-group list-unstyled kss_sort mb-0">
              <li class="list-group-item pl-2">
                <a href="#" class="text-dark"><i class="kss_icon popularity"></i> Popularity</a>
              </li>
              <li class="list-group-item pl-2">
                <a href="#" class="text-dark"><i class="kss_icon latest"></i> Latest</a>
              </li>
              <li class="list-group-item pl-2">
                <a href="#" class="text-dark"><i class="kss_icon discount"></i> Discount</a>
              </li>
              <li class="list-group-item pl-2">
                <a href="#" class="text-dark"><i class="kss_icon price-h"></i> Price: High to Low</a>
              </li>
              <li class="list-group-item pl-2">
                <a href="#" class="text-dark"><i class="kss_icon price-l"></i> Price: Low to High</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="fixed-bottom d-block d-md-none">
        <div class="row no-gutters">
            <div class="col-6 text-center b-r">
                 <button data-toggle="modal" data-target="#kss_sort" type="button" class="btn btn-lg btn-block text-dark h-100 text-uppercase"><i class="fa-sort-amount-down fas pr-1"></i> <span class="text-secondary">Sort</span></button>
            </div> 
            <div class="col-6 text-center">
                <button id="filter" type="button" class="btn btn-lg btn-block btn-primary text-dark h-100 text-uppercase"><i class="fa-filter fas pr-1"></i> <span class="text-secondary">Filter</span></button>
            </div>
        </div>
    </div>