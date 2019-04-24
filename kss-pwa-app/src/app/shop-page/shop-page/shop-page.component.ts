import { Component, OnInit, isDevMode } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';
import { BreakpointObserver, Breakpoints } from '@angular/cdk/layout';
import { PaginationInstance } from 'ngx-pagination';

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

  constructor(private apiService: ApiServiceService,
              private appservice : AppServiceService,
              private route: ActivatedRoute,
              private breakpointObserver : BreakpointObserver) {
      this.isMobile = this.breakpointObserver.isMatched('(max-width: 600px)');
    }

  ngOnInit() {
    this.getFilters();
    this.callListPageApi();
    this.getFiltersCount();
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
      console.log("product list api response ==>",this.listPage);
    },
    (error)=>{
      console.log("error ===>", error);
      this.listPage = null;
      this.showLoader = false;
    });
  }

  getFilters(){
    this.showFilterLoader = true;
    let url = isDevMode() ? "https://demo8558685.mockable.io/get-filters" : this.appservice.apiUrl + '/api/rest/v1/get-filters';
    // url = "https://demo8558685.mockable.io/get-filters";
    this.apiService.request(url, 'get', {} , {}, false, 'promise').then((response)=>{
      console.log("get filters api response ==>",response);
      this.showFilterLoader = false;
      response.filters = response.filters.sort((a,b)=>{ return(a.order - b.order) });
      this.selectedFilterCategory = response.filters[0].header.facet_name;
      this.filters = response.filters;
      this.filtersCopy = Object.assign([], this.filters);
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.showFilterLoader = false;
    });
  }

  getFiltersCount(){
    let url = isDevMode() ? "https://demo8558685.mockable.io/get-filters" : this.appservice.apiUrl + '/api/rest/v1/get-filters-count';
    // url = "https://demo8558685.mockable.io/get-filters";
    if(Object.keys(this.queryObject).length != 0)
      url = url + '?' + $.param(this.queryObject);
    this.apiService.request(url, 'get', {} , {}, false, 'promise').then((response)=>{
      console.log("get filters api response ==>",response);
      response.filters = response.filters.sort((a,b)=>{ return(a.order - b.order) });
      this.selectedFilterCategory = response.filters[0].header.facet_name;
      this.filters = response.filters;
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
    console.log("applyFilter", search_text);
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
    console.log("applyCheckboxFilter ==>", filter);
    if(filter.filter_type != "boolean_filter"){
      if(filter.apply)
        this.queryObject[filter.category] ? this.queryObject[filter.category].push(filter.value) : this.queryObject[filter.category] = [filter.value];
      else
        this.queryObject[filter.category] = this.queryObject[filter.category].filter((value)=> {return value != filter.value});
    }
    else{
      if(filter.apply)
        this.queryObject[filter.category] = filter.value;
      else
        delete this.queryObject[filter.category]
    }
    console.log("queryObject ==>", this.queryObject);
    this.updateListPage();
  }

  applyRangeFilter(filter){
    this.queryObject.price = {};
    this.queryObject.price['min'] = filter.value.start;
    this.queryObject.price['max'] = filter.value.end;
    console.log("queryObject ==>", this.queryObject);
    this.updateListPage();
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
