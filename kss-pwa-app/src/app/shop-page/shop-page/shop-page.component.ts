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

@Component({
  selector: 'app-shop-page',
  templateUrl: './shop-page.component.html',
  styleUrls: ['./shop-page.component.scss']
})
export class ShopPageComponent implements OnInit {

  listApiCall : any;
  listPage : any = {
    page : {
      current : 1,
      display_limit : 30,
      has_next : true,
      has_previous : false,
      total : 21,
      total_item_count : 618
    }
  };
  showLoader : boolean = false;
  showFilterLoader : boolean = false;
  filters : any;
  sortOn : any = '';
  isMobile : boolean = false;
  selectedFilterCategory : any;
  queryObject : any = {};
  sort_on = [
    {
      name: "Recommended",
      value: "",
      is_selected: true,
      class: "popularity"
    },
    {
      name: "Price Low to High",
      value : "price_asc",
      is_selected: false,
      class: "price-l"
    },
    {
      name: "Price High to Low",
      value: "price_desc",
      is_selected: false,
      class: "price-h"
    }
  ]

  page : any = {
    current : 1,
    display_limit : 30,
    has_next : true,
    has_previous : false,
    total : 21,
    total_item_count : 618
  }
  filtersCopy : any;

  public config: PaginationInstance = {
      id: 'list-page',
      itemsPerPage: this.listPage.page.display_limit,
      currentPage: this.listPage.page.current,
      totalItems: this.listPage.page.total_item_count
  };

  urlRoutes = {};
  primaryFilters = {};
  rangeFilter = {};
  booleanFilter = {};

  constructor(private apiService: ApiServiceService,
              private appservice : AppServiceService,
              private route: ActivatedRoute,
              private breakpointObserver : BreakpointObserver,
              private router: Router) {
      this.isMobile = this.breakpointObserver.isMatched('(max-width: 600px)');
    }

  ngOnInit() {
    console.log("%%%%%%%%%%% ngOnInit %%%%%%%%%%%%%%");
    this.getFilters();
    combineLatest(this.route.params, this.route.queryParams)
      .pipe(map(results => ({route: results[0], query: results[1]})))
        .subscribe(results => {
          // console.log(results);
          for (const [key,value] of Object.entries(results.route)){
            this.queryObject['pf'] ? this.queryObject['pf'].push(value) : this.queryObject['pf'] = [value];
          }

          if(results.query.pf)
            this.formatPFQueryParams(results.query.pf);
          if(results.query.rf)
            this.formatRangeFilter(results.query.rf);
          if(results.query.bf)
            this.formatBooleanParams(results.query.bf);

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

  status: boolean = false;
  mobilefilter: boolean = false;

  clickEvent(){
    this.status = !this.status;
  }

  showMobileFilter(){
    this.mobilefilter = !this.mobilefilter;
  }

  callListPageApi(){
    window.scrollTo(0, 0)
    this.mobilefilter = false;
    this.showLoader = true;
    this.createDummyList();
    this.unsubscribeListPageApi();
    let url = isDevMode() ? "https://demo8558685.mockable.io/product-list" : this.appservice.apiUrl + '/api/rest/v1/product-list';
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
      })
      this.listPage = response;
      this.showLoader = false;

      this.config.itemsPerPage = this.listPage.page.display_limit;
      this.config.currentPage = this.listPage.page.current;
      this.config.totalItems = this.listPage.page.total_item_count;
      // console.log("product list api response ==>",this.listPage);
    },
    (error)=>{
      console.log("error ===>", error);
      this.listPage = null;
      this.showLoader = false;
    });
  }

  getFilters(){
    if(this.appservice.filters)
      this.filters = this.appservice.filters
    else{
      this.showFilterLoader = true;
      let url = isDevMode() ? "https://demo8558685.mockable.io/get-filters" : this.appservice.apiUrl + '/api/rest/v1/get-filters';
      // url = "https://demo8558685.mockable.io/get-filters";
      this.apiService.request(url, 'get', {} , {}, false, 'promise').then((response)=>{
        // console.log("get filters api response ==>",response);
        this.showFilterLoader = false;
        response.filters = response.filters.sort((a,b)=>{ return(a.order - b.order) });
        this.selectedFilterCategory = response.filters[0].header.facet_name;
        this.filters = response.filters;
        this.appservice.filters = this.filters;
        this.filtersCopy = Object.assign([], this.filters);
      })
      .catch((error)=>{
        console.log("error ===>", error);
        this.showFilterLoader = false;
      });
    }
  }

  getFiltersCount(){
    let url = isDevMode() ? "https://demo8558685.mockable.io/get-filters" : this.appservice.apiUrl + '/api/rest/v1/get-filters-count';
    // url = "https://demo8558685.mockable.io/get-filters";
    if(Object.keys(this.queryObject).length != 0)
      url = url + '?' + $.param(this.queryObject);
    this.apiService.request(url, 'get', {} , {}, false, 'promise').then((response)=>{
      // console.log("get filters api response ==>",response);
      response.filters = response.filters.sort((a,b)=>{ return(a.order - b.order) });
      this.selectedFilterCategory = response.filters[0].header.facet_name;
      this.filters = response.filters;
      // this.urlRoutes = {}; // uncomment once filter count api is ready
      // this.primaryFilters = {};
      this.filters.forEach(filter =>{
        filter.items.forEach(item =>{
          // separately handle for route and query params
          if(item.is_selected)
            this.updateUrlRoute(filter.attribute_param, item.slug, true);
        })
      })
    })
    .catch((error)=>{
      console.log("error ===>", error);
    });
  }

  createDummyList(){
    let product = {
      url : '',
      image : '',
      title : '',
      sale_price : '',
      list_price : ''
    }
    this.listPage = {};
    this.listPage['page'] = this.page;
    this.listPage['items'] = [];
    for (let i = 0; i < 8; i++){
      this.listPage.items.push(product);
    }
  }

  unsubscribeListPageApi(){
    if(this.listApiCall)
      this.listApiCall.unsubscribe();
  }

  searchByText(search_text){
    // console.log("applyFilter", search_text);
    this.queryObject.search_string = search_text;
    console.log("queryObject ==>", this.queryObject);
    this.updateListPage();
  }

  sortBy(mobile_sort : any = ''){
    if(mobile_sort){
      //close modal and call get filters and get product list api
      console.log("mobile sort by ==>", mobile_sort);
      this.queryObject.sort_on = mobile_sort;
    }
    else{
      console.log("sortBy ==>", this.sortOn);
      this.queryObject.sort_on = this.sortOn;
    }
    console.log("queryObject ==>", this.queryObject);
    this.updateListPage();
  }

  pageChanged(page:number){
    console.log("pageChanged ==>", page);
    this.queryObject.page = page;
    console.log("queryObject ==>", this.queryObject);
    this.callListPageApi();
  }

  applyCheckboxFilter(filter){
    // console.log("applyCheckboxFilter ==>", filter);
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
    this.setRouteParam();
    // console.log("queryObject ==>", this.queryObject);
    // this.updateListPage();
  }

  setRouteParam(){
    console.log("this.urlRoutes ==>", this.urlRoutes);
    let path = '';

    for (const prop in this.urlRoutes) {
      // console.log(`obj.${prop} = ${obj[prop]}`);
      if( this.urlRoutes[prop].length )
        path = path + '/' + this.urlRoutes[prop].join('--');
    }

    // for(const [key,value] of Object.entries(this.urlRoutes)){
    //   if(value && Object.keys(value).length){
    //     path = path + '/' + value.join('--');
    //   }
    // }

    let query_params = ''
    for (const prop in this.primaryFilters) {
      if( this.primaryFilters[prop].length )
        query_params ? query_params = query_params + '|'  + prop + ':' + this.primaryFilters[prop].join(',') : query_params = query_params + prop + ':' + this.primaryFilters[prop].join(',')
    }
    // for(const [key,value] of Object.entries(this.primaryFilters)){
    //   if(value && Object.keys(value).length){
    //     query_params ? query_params = query_params + '|'  + key + ':' + value.join(',') : query_params = query_params + key + ':' + value.join(',')
    //   }
    // }
    if(query_params)
      query_params = '?pf=' + query_params;
    

    if(this.rangeFilter['price'])
      query_params ? query_params = query_params + '&rf=' + this.rangeFilter['price'] : query_params =  '?rf=' + this.rangeFilter['price']

    let boolean_filters = ''
    for (const prop in this.booleanFilter) {
      if( this.booleanFilter[prop].length )
        boolean_filters ? boolean_filters = boolean_filters + '|'  + prop + ':' + this.booleanFilter[prop] : boolean_filters = boolean_filters + prop + ':' + this.booleanFilter[prop];
    }
    // for(const [key,value] of Object.entries(this.booleanFilter)){
    //   if(value && Object.keys(value).length){
    //     boolean_filters ? boolean_filters = boolean_filters + '|'  + key + ':' + value : boolean_filters = boolean_filters + key + ':' + value;
    //   }
    // }

    if(boolean_filters)
      query_params ? query_params = query_params + '&bf=' + boolean_filters : query_params =  '?bf=' + boolean_filters;

    if(!path)
      path = '/shop'
    let url = path + query_params;
    console.log("check path ==>", url);
    this.router.navigateByUrl(url);
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
    this.rangeFilter['price'] = 'price:'+ filter.value.start + 'TO' + filter.value.end;
  }

  updateListPage(){
    // this.isMobile ? this.getFiltersCount() : this.callListPageApi();
    if(!this.isMobile)
      this.callListPageApi();
  }

  resetFilters(){
    this.filters = Object.assign([], this.filtersCopy);
    console.log("on reset filter ==>", this.filters)
    this.mobilefilter = false;
  }

}
