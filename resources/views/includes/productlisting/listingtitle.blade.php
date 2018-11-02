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
  <div class="d-flex">
    <div>
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                 @{{#each breadcrumbs.list}}
                <li class="breadcrumb-item"><a href="@{{href}}">@{{name}}</a></li>
                @{{/each}}
                @{{#if breadcrumbs.current}}
                <li class="breadcrumb-item active"><a href="#">@{{breadcrumbs.current}}</a></li>
                @{{/if}}
            </ol>
          </nav>
         <h1 class="w-100 kss-title m-0 text-gray font-weight-bold">
            @{{headers.page_title}} <span class="f-w-4 sub-text"> - @{{headers.product_count}}</span>
         </h1>
    </div>
    <div class="ml-auto d-none d-md-block">
      <div class="d-flex flex-row kss-select-border mt-2">
      <div class="size-qty align-self-center">
        <h6 class="m-0 f-w-4 sub-text"> Sort By:</h6>
      </div>
      <div class="pl-2 align-self-center">
        <select class="size form-control  form-control-sm br-0  border-dark custom"  >
          <option>Popularity</option>
              <option>Latest</option>
              <option>Discount</option>
              <option>Price: High to Low</option>
              <option>Price: Low to High</option>
        </select> 
      </div>
    </div>
    </div>
  </div>
</script>
<div id="filter-header-template-content"></div>
<script id="filter-tags-template" type="text/x-handlebars-template">
  <div class="d-none d-md-block filter-selection">
    <div class="d-flex mt-3 ">
      @{{#each filter_tags_list}}
        <div class="border border-dark p-1 mr-2 "><span data-slug="@{{slug}}">@{{value}}</span> <span class="ml-1 h6 kss_highlight" aria-hidden="true" onclick="removeFilterTag('@{{slug}}');">&times;</span></div>
      @{{/each}}
      <div class=" p-1 mr-2"><a href="#" class="font-weight-bold kss-link clear-filter" >Clear All</a></div>
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
   console.log("filter tags====")
   console.log(context)
   var html    = template(context);
   document.getElementById("filter-header-template-content").innerHTML = html;
  </script>
@endsection

