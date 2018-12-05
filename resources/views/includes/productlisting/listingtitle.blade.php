<div class="d-none ">
	<div class="row mt-2">
		<div class="col-sm-6">
			<i class="d-block mt-2"> Showing 300 items</i>
		</div>
		<div class="col-sm-6 ">
			<form class="form-inline float-right">
			  <div class="form-group mb-2">
			   Sort By
			  </div>
			  <div class="form-group mx-sm-3 mb-2">
  			  <select class="form-control custom">
  				  <option>Popularity</option>
  				  <option>Latest</option>
  				  <option>Discount</option>
  				  <option>Price: High to Low</option>
  				  <option>Price: Low to High</option>
  				</select>
			  </div>
			</form>
		</div>
	</div>
</div>
<script id="filter-header-template" type="text/x-handlebars-template">
  <div class="d-flex align-items-sm-center">
    <div class="flex-fill-full">
<!--             <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                 @{{#each breadcrumbs.list}}
                <li class="breadcrumb-item"><a href="@{{href}}">@{{name}}</a></li>
                @{{/each}}
                @{{#if breadcrumbs.current}}
                <li class="breadcrumb-item active"><a href="#">@{{breadcrumbs.current}}</a></li>
                @{{/if}}
            </ol>
          </nav> -->
        <h1 class="w-100 kss-title m-0 text-gray font-weight-bold">
            @{{headers.page_title}} <span class="f-w-4 sub-text"> - @{{headers.product_count}} items</span>
        </h1>
    </div>

    <div class="ml-sm-auto d-flex flex-fill-full justify-content-end">
      @{{#if show_search}}
      <div class="d-flex align-items-sm-center position-relative">
        <div class="expandSearch d-flex align-items-sm-center justify-content-sm-end">
          <input type="search" id="searchStringInp" class="custom-expand-search form-control" placeholder="Search for Product" title="Search for:" value="@{{search_string}}">
          <a href="javascript:void(0);" class="search-trigger d-inline-flex">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="375.045 607.885 30.959 30.33" enable-background="new 375.045 607.885 30.959 30.33" xml:space="preserve">
              <path fill="#000" class="search-path" d="M405.047,633.805l-7.007-6.542c-0.129-0.121-0.267-0.226-0.408-0.319c1.277-1.939,2.025-4.258,2.025-6.753 c0-6.796-5.51-12.306-12.307-12.306s-12.306,5.51-12.306,12.306s5.509,12.306,12.306,12.306c2.565,0,4.945-0.786,6.916-2.128 c0.122,0.172,0.257,0.337,0.418,0.488l7.006,6.542c1.122,1.048,2.783,1.093,3.709,0.101 C406.327,636.507,406.169,634.853,405.047,633.805z M387.351,629.051c-4.893,0-8.86-3.967-8.86-8.86s3.967-8.86,8.86-8.86 s8.86,3.967,8.86,8.86S392.244,629.051,387.351,629.051z"></path>
            </svg>
          </a>
        </div>        
      </div>
      @{{/if}}
      <div class="kss-select-border mt-2 d-none d-md-flex">
        <div class="size-qty align-self-center">
          <h6 class="m-0 f-w-4 sub-text"> Sort By:</h6>
        </div>
        <div class="pl-2 align-self-center">
          <select class="size form-control  form-control-sm br-0  border-dark custom"  onChange="facetCategoryChange(this,true,false,false,true);">
          @{{#each sort_on}}
            <option value="@{{value}}" @{{#if is_selected}} selected="selected" @{{/if}}>@{{name}}</option>
          @{{/each}}
          </select> 
        </div>
      </div>
    </div>
  </div>
</script>
<div id="filter-header-template-content"></div>
<script id="filter-tags-template" type="text/x-handlebars-template">
  <div class="d-none d-md-block filter-selection">
    <div class="d-flex mt-3 flex-wrap">
      @{{#each filter_tags_list}}
        <div class="border border-dark p-1 mr-2 mb-2"><span data-slug="@{{slug}}">@{{value}}</span> <span class="ml-1 h6 kss_highlight" aria-hidden="true" onclick="removeFilterTag('@{{slug}}');">&times;</span></div>
      @{{/each}}
      <!-- <div class=" p-1 mr-2"><a href="#" class="font-weight-bold kss-link clear-filter" >Clear All</a></div> -->
    </div>
  </div>
</script>
<div id="filter-tags-template-content"></div>
<hr class="d-none d-sm-block">

@section('footjs-filter-tags')  
  <script type="text/javascript" >
   var source   = document.getElementById("filter-header-template").innerHTML;
   var template = Handlebars.compile(source);
   var context = {};
   context["breadcrumbs"] = <?= json_encode($breadcrumbs) ?> ;
   context["headers"] = <?= json_encode($headers) ?> ;
   context["sort_on"] = <?= json_encode($sort_on) ?> ;
   context["show_search"] = <?= json_encode($show_search) ?> ;
   context["search_string"] = <?= json_encode($search_string) ?> ;
   var html    = template(context);
   document.getElementById("filter-header-template-content").innerHTML = html;
  </script>
@endsection

