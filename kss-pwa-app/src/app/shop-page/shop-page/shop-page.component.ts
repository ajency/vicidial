import { Component, OnInit, isDevMode } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';
import { BreakpointObserver, Breakpoints } from '@angular/cdk/layout';
import { PaginationInstance } from 'ngx-pagination';
import { Router }  from '@angular/router';
import { combineLatest } from 'rxjs';
import { map } from 'rxjs/operators';

declare var $: any;
declare var gtagTrackListPage : any;

@Component({
  selector: 'app-shop-page',
  templateUrl: './shop-page.component.html',
  styleUrls: ['./shop-page.component.scss']
})
export class ShopPageComponent implements OnInit {

  listApiCall : any;
  filterCountApiCall : any;
  listPage : any = {};
  showLoader : boolean = false;
  showFilterLoader : boolean = false;
  filters : any;
  sortOn : any = '';
  isMobile : boolean = false;
  selectedFilterCategory : any;
  queryObject : any = {};
  sort_on : any
  page : any = {
    current : 1,
    display_limit : 40,
    has_next : true,
    has_previous : false,
    total : 21,
    total_item_count : 618
  }
  filtersCopy : any;

  public config: PaginationInstance = {
      id: 'list-page',
      itemsPerPage: 40,
      currentPage: 1,
      totalItems: 618
  };

  urlRoutes = {};
  primaryFilters = {};
  rangeFilter = {};
  booleanFilter = {};
  searchString : any = '';
  pageNumber : any;
  showRangeFilter : any;
  filterCollpaseArray = [];

  constructor(private apiService: ApiServiceService,
              private appservice : AppServiceService,
              private route: ActivatedRoute,
              private breakpointObserver : BreakpointObserver,
              private router: Router) {
      this.isMobile = this.breakpointObserver.isMatched('(max-width: 600px)');
    }

  ngOnInit() {
    console.log("%%%%%%%%%%% ngOnInit %%%%%%%%%%%%%%");
    this.listPage['page'] = this.page;
    this.getFilters();
    combineLatest(this.route.params, this.route.queryParams)
      .pipe(map(results => ({route: results[0], query: results[1]})))
        .subscribe(results => {
          console.log("results ==>", results);
          this.queryObject = {};
          // for (const [key,value] of Object.entries(results.route)){
          //   if(value)
          //     this.queryObject['pf'] ? this.queryObject['pf'].push(value) : this.queryObject['pf'] = [value];
          // }
          for (const key in results.route) {
            if(results.route[key])
              this.queryObject['pf'] ? this.queryObject['pf'].push(results.route[key]) : this.queryObject['pf'] = [results.route[key]];
          }

          if(results.query.pf)
            this.formatPFQueryParams(results.query.pf);
          if(results.query.rf)
            this.formatRangeFilter(results.query.rf);
          if(results.query.bf)
            this.formatBooleanParams(results.query.bf);
          if(results.query.search_string)
            this.queryObject.search_string = results.query.search_string;
          if(results.query.sort_on)
            this.queryObject.sort_on = results.query.sort_on;
          if(results.query.page)
            this.queryObject.page = results.query.page;

          this.callListPageApi();
          this.getFiltersCount();
    });
  }

  formatPFQueryParams(pf){
    let params = pf.split('|');
    params.forEach((param =>{
      let filter = param.split(':')
      let filter_values = filter[1].split(',');
      this.queryObject[filter[0]] = filter_values;
    }))
  }

  formatRangeFilter(rf){
    let params = rf.split('|');
    params.forEach((param =>{
      let filter = param.split(':');
      let filter_values = filter[1].split('TO');
      this.queryObject.price = {};
      this.queryObject.price['min'] = parseInt(filter_values[0]);
      this.queryObject.price['max'] = parseInt(filter_values[1]);
    }))
  }

  formatBooleanParams(bf){
    let params = bf.split('|');
    params.forEach((param =>{
      let filter = param.split(':')
      this.queryObject[filter[0]] = filter[1];
    }))
  }

  mobilefilter: boolean = false;

  showMobileFilter(){
    this.mobilefilter = !this.mobilefilter;
  }

  ngOnDestroy(){
    this.unsubscribeListPageApi();
    this.unsubscribeFilterCountApiCall();
  }

  callListPageApi(){
    window.scrollTo(0, 0)
    this.mobilefilter = false;
    this.showLoader = true;
    this.createDummyList();
    this.unsubscribeListPageApi();
    let url = isDevMode() ? "https://demo8558685.mockable.io/product-list" : this.appservice.apiUrl + '/api/rest/v2/product-list';
    // url = "https://demo8558685.mockable.io/product-list";
    if(Object.keys(this.queryObject).length != 0)
      url = url + '?' + $.param(this.queryObject);
    this.listApiCall = this.apiService.request(url, 'get', {} , {}, false, 'observable').subscribe((response)=>{
      response.items.forEach(item=>{
        item.url = '/'+item.attributes.product_slug+'/buy';
        item.image = item.images.length ? item.images[0].main : null;
        item.title = item.attributes.product_title;
        let default_variant = item.variants.find((variant)=>{return variant.is_default === true});
        item.sale_price = default_variant.variant_attributes.variant_sale_price;
        item.list_price = default_variant.variant_attributes.variant_list_price;
        item.brand = item.facets.product_brand.name;
        item.is_available = item.is_available;
        item.is_sellable = item.is_sellable;
      })
      try{
        gtagTrackListPage();
      }
      catch(e){
        console.log("gtagTrackListPage error ==>", e);
      }
      this.listPage = response;
      this.setPaginationDefaults();
      this.showLoader = false;
    },
    (error)=>{
      console.log("error ===>", error);
      this.listPage = null;
      this.showLoader = false;
    });
  }

  setPaginationDefaults(){
    this.config.itemsPerPage = this.listPage.page.display_limit;
    this.config.currentPage = this.listPage.page.current;
    this.config.totalItems = this.listPage.page.total_item_count;
  }

  getFilters(){
    if(this.appservice.filters){
      this.filters = this.appservice.filters
      this.filterCollpaseArray = this.appservice.filterCollpaseArray;
      // this.sort_on = this.appservice.sort_on;
    }
    else{
      this.showFilterLoader = true;
      let url = isDevMode() ? "https://demo8558685.mockable.io/get-filters" : this.appservice.apiUrl + '/api/rest/v2/get-filters';
      // url = "https://demo8558685.mockable.io/get-filters";
      this.apiService.request(url, 'get', {} , {}, false, 'promise').then((response)=>{
        this.showFilterLoader = false;
        this.formatFilters(response);
        this.appservice.filters = response.filters.sort((a,b)=>{ return(a.order - b.order) });
        this.filterCollpaseArray = []
        this.filters.forEach(filter => {this.filterCollpaseArray.push({type:filter.attribute_param,is_collapsed : filter.is_collapsed})})
        this.appservice.filterCollpaseArray = this.filterCollpaseArray;
      })
      .catch((error)=>{
        console.log("error ===>", error);
        this.showFilterLoader = false;
      });
    }
  }

  getFiltersCount(updateFilterCopy : boolean = true){
    this.unsubscribeFilterCountApiCall();
    let url = isDevMode() ? "https://demo8558685.mockable.io/get-filters" : this.appservice.apiUrl + '/api/rest/v2/get-filters-count';
    // url = "https://demo8558685.mockable.io/get-filters";
    if(Object.keys(this.queryObject).length != 0)
      url = url + '?' + $.param(this.queryObject);
    this.filterCountApiCall = this.apiService.request(url, 'get', {} , {}, false, 'observable').subscribe((response)=>{
      this.formatFilters(response, updateFilterCopy);
      this.sort_on = response.sort_on;
      let sort_by = this.sort_on.find(item => { return item.is_selected });
      this.sortOn = sort_by.value;
      this.appservice.sort_on = this.sort_on;
      this.urlRoutes = {}; 
      this.primaryFilters = {};
      this.rangeFilter = {};
      this.booleanFilter = {};
      this.isRangeFilterActive();
      this.setFilters()
    },
    (error)=>{
      console.log("error ===>", error);
    });
  }

  formatFilters(response, updateFilterCopy : boolean = true){
    response.filters = response.filters.sort((a,b)=>{ return(a.order - b.order) });
    if(!this.selectedFilterCategory)
      this.selectedFilterCategory = response.filters[0].header.facet_name;
    this.filters = response.filters;
    this.searchString = response.search_string;

    if(updateFilterCopy)
      this.filtersCopy = JSON.parse(JSON.stringify( this.filters ));
  }

  createDummyList(){
    let product = {
      url : '',
      image : '',
      title : '',
      sale_price : '',
      list_price : '',
      is_available : true,
      is_sellable : true
    }
    this.listPage = {};
    this.listPage['page'] = this.page;
    this.listPage['items'] = [];
    for (let i = 0; i < 8; i++){
      this.listPage.items.push(product);
    }
  }

  setFilters(){
    this.urlRoutes = {}; 
    this.filters.forEach(filter =>{
      filter.items.forEach(item =>{
        if(item.is_selected)
          this.updateQueryObjects({filter : filter, value : item.slug, apply : item.is_selected })
      })
    })
  }

  unsubscribeListPageApi(){
    if(this.listApiCall)
      this.listApiCall.unsubscribe();
  }

  unsubscribeFilterCountApiCall(){
    if(this.filterCountApiCall)
      this.filterCountApiCall.unsubscribe(); 
  }

  searchByText(search_text){
    this.searchString = search_text;
    this.pageNumber = '';
    this.setRouteParam();
  }

  sortBy(mobile_sort : any = ''){
    if(mobile_sort){
      console.log("mobile sort by ==>", mobile_sort);
      this.sortOn = mobile_sort;
    }
    this.pageNumber = '';
    this.setRouteParam(true);
  }

  pageChanged(page:number){
    console.log("pageChanged ==>", page);
    this.pageNumber = page;
    this.setRouteParam(true);
  }

  applyCheckboxFilter(filter){
    console.log("applyCheckboxFilter ==>", filter);
    try{
      console.log(filter.filter);
    }
    catch(error){
      console.log("error ==>", error);
    }
    this.updateQueryObjects(filter);    
    this.pageNumber = '';
    this.setRouteParam();
  }

  updateQueryObjects(filter){
    try{
      if(!filter.filter.is_attribute_param){
        this.updateUrlRoute(filter.filter.attribute_param, filter.value, filter.apply);
      }
      else{
        if(filter.filter.filter_type == "primary_filter"){
          this.updatePrimaryQueryParam(filter.filter.attribute_param, filter.value, filter.apply);
        }
        else if(filter.filter.filter_type == "boolean_filter"){
          if(filter.apply)
            this.booleanFilter[filter.filter.attribute_param] = filter.value;
          else
            delete this.booleanFilter[filter.filter.attribute_param]
        }
      }
    }
    catch(error){
      // console.log("error in if else ==>", error);
    }
  }

  setRouteParam(callProductListForMobile : boolean = false){
    console.log("this.urlRoutes ==>", this.urlRoutes);
    let path = '';

    for (const prop in this.urlRoutes) {
      if( this.urlRoutes[prop].length )
        path = path + '/' + this.urlRoutes[prop].join('--');
    }

    let query_params = ''
    for (const prop in this.primaryFilters) {
      if( this.primaryFilters[prop].length )
        query_params ? query_params = query_params + '|'  + prop + ':' + this.primaryFilters[prop].join(',') : query_params = query_params + prop + ':' + this.primaryFilters[prop].join(',')
    }
    if(query_params)
      query_params = '?pf=' + query_params;

    if(this.rangeFilter['price'])
      query_params ? query_params = query_params + '&rf=' + this.rangeFilter['price'] : query_params =  '?rf=' + this.rangeFilter['price']

    let boolean_filters = ''
    for (const prop in this.booleanFilter) {
      if( this.booleanFilter[prop].length )
        boolean_filters ? boolean_filters = boolean_filters + '|'  + prop + ':' + this.booleanFilter[prop] : boolean_filters = boolean_filters + prop + ':' + this.booleanFilter[prop];
    }

    if(boolean_filters)
      query_params ? query_params = query_params + '&bf=' + boolean_filters : query_params =  '?bf=' + boolean_filters;

    if(this.searchString)
      query_params ? query_params = query_params + '&search_string=' + this.searchString : query_params =  '?search_string=' + this.searchString; 

    if(this.sortOn)
      query_params ? query_params = query_params + '&sort_on=' + this.sortOn : query_params =  '?sort_on=' + this.sortOn;

    if(this.pageNumber)
      query_params ? query_params = query_params + '&page=' + this.pageNumber : query_params =  '?page=' + this.pageNumber;    

    if(!path)
      path = '/shop'
    let url = path + query_params;
    console.log("check path ==>", url);
    if(!this.isMobile || callProductListForMobile)
      this.router.navigateByUrl(url);
    else{
      this.createQueryObjectForCountApi()
    }
  }

  applyFilter(){
    this.setRouteParam(true);
    this.mobilefilter = false;
  }

  createQueryObjectForCountApi(){
    this.queryObject = {};
    this.queryObject = Object.assign({}, this.urlRoutes, this.primaryFilters, this.booleanFilter);
    if(this.rangeFilter['price'])
      this.formatRangeFilter(this.rangeFilter['price']);
    if(this.searchString)
      this.queryObject['search_string'] = this.searchString;
    if(this.sortOn)
      this.queryObject['sort_on'] = this.sortOn;
    if(this.pageNumber)
      this.queryObject['page'] = this.pageNumber;

    this.getFiltersCount(false);
  }

  updateUrlRoute(cat,value,apply){
    if(apply)
      this.urlRoutes[cat] ? this.urlRoutes[cat].push(value) : this.urlRoutes[cat] = [value];
    else
      this.urlRoutes[cat] = this.urlRoutes[cat].filter(item => item != value);

    console.log("urlRoutes ==>", this.urlRoutes);
  }

  updatePrimaryQueryParam(cat,value,apply){
    if(apply)
      this.primaryFilters[cat] ? this.primaryFilters[cat].push(value) : this.primaryFilters[cat] = [value];
    else
      this.primaryFilters[cat] = this.primaryFilters[cat].filter(item => item != value);

    console.log("primaryFilters ==>", this.primaryFilters); 
  }

  applyRangeFilter(filter){
    this.rangeFilter['price'] = '';
    this.isRangeFilterActive();
    this.setRouteParam();
  }

  isRangeFilterActive(){
    let range_filter = this.filters.find((filter)=>{ return filter.attribute_param === 'price' });
    console.log("range_filter ==>",range_filter);
    if(range_filter.bucket_range.start != range_filter.selected_range.start || range_filter.bucket_range.end != range_filter.selected_range.end){
      this.showRangeFilter = true;
      this.rangeFilter['price'] = 'price:'+ range_filter.selected_range.start + 'TO' + range_filter.selected_range.end;
    }
    else{
      this.showRangeFilter = false;
    }
  }

  resetFilters(){
    console.log("on reset filter ==>", this.filters)
    this.resetFilterQueryObject();
  }

  resetFilterQueryObject(){
    this.filters.forEach(filter =>{
      filter.items.forEach(item =>{
          item.is_selected = false;
          this.updateQueryObjects({filter : filter, value : item.slug, apply : false })
      })
    })
  }

  removeFilter(filter, item){
    if(filter.attribute_param != 'price'){
      item.is_selected = false;
      console.log("filter ===========>", filter)
      this.applyCheckboxFilter({filter : filter, value : item.slug, apply : false })
    }
    else{
      filter.selected_range = Object.assign({}, filter.bucket_range);
      this.applyRangeFilter({category : filter.attribute_param, value : filter.bucket_range}) 
    }
  }

  revertFilters(){
    this.unsubscribeFilterCountApiCall();
    this.filters = JSON.parse(JSON.stringify( this.filtersCopy ));
    this.setFilters();
    this.mobilefilter = false;
  }

  getSelectedItemCount(filter){
    let count = filter.items.filter(i => i.is_selected === true).length;
    if(count)
      return count;
  }

}
