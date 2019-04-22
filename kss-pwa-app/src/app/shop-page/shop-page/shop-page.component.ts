import { Component, OnInit, isDevMode } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';
import { BreakpointObserver, Breakpoints } from '@angular/cdk/layout';

declare var $: any;

@Component({
  selector: 'app-shop-page',
  templateUrl: './shop-page.component.html',
  styleUrls: ['./shop-page.component.scss']
})
export class ShopPageComponent implements OnInit {

  listApiCall : any;
  listPage : any = {};
  showLoader : boolean = false;
  filters : any;
  sortOn : any = 'recommended';
  isMobile : boolean = false;
  selectedFilterCategory : any;
  queryObject : any = {};
  sort_on = [
    {
      name: "Recommended",
      value: "recommended",
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
    this.mobilefilter = false;
    this.showLoader = true;
    this.createDummyList();
    this.unsubscribeListPageApi();
    let url = isDevMode() ? "https://demo8558685.mockable.io/product-list?" : this.appservice.apiUrl + '/api/rest/v1/product-list?';
    // url = "https://demo8558685.mockable.io/product-list";
    url = url + $.param(this.queryObject);
    this.listApiCall = this.apiService.request(url, 'get', {} , {}, false, 'observable').subscribe((response)=>{
      response.items.forEach(item=>{
        item.url = '/'+item.attributes.product_slug+'/buy';
        item.image = item.images[0].main;
        item.title = item.attributes.product_title;
        let default_variant = item.variants.find((variant)=>{return variant.is_default === true});
        item.sale_price = default_variant.variant_attributes.variant_sale_price;
        item.list_price = default_variant.variant_attributes.variant_list_price;
        item.brand = item.facets.product_brand.name;
      })
      this.listPage = response;
      this.showLoader = false;
      console.log("product list api response ==>",this.listPage);
    },
    (error)=>{
      console.log("error ===>", error);
      this.showLoader = false;
    });
  }

  getFilters(){
    let url = isDevMode() ? "https://demo8558685.mockable.io/get-filters" : this.appservice.apiUrl + '/api/rest/v1/get-filters';
    // url = "https://demo8558685.mockable.io/get-filters";
    this.apiService.request(url, 'get', {} , {}, false, 'promise').then((response)=>{
      console.log("get filters api response ==>",response);
      response.filters = response.filters.sort((a,b)=>{ return(a.order - b.order) });
      this.selectedFilterCategory = response.filters[0].header.facet_name;
      this.filters = response.filters;
      this.filtersCopy = Object.assign([], this.filters);
    })
    .catch((error)=>{
      console.log("error ===>", error);
    });
  }

  getFiltersCount(){
    let url = isDevMode() ? "https://demo8558685.mockable.io/get-filters?" : this.appservice.apiUrl + '/api/rest/v1/get-filters-count?';
    // url = "https://demo8558685.mockable.io/get-filters";
    url = url + $.param(this.queryObject);
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
    this.listPage.items = [];
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
    this.updateListPage();
  }

  applyCheckboxFilter(filter){
    console.log("applyCheckboxFilter ==>", filter);
    if(filter.apply)
      this.queryObject[filter.category] ? this.queryObject[filter.category].push(filter.value) : this.queryObject[filter.category] = [filter.value];
    else
      this.queryObject[filter.category] = this.queryObject[filter.category].filter((value)=> {return value != filter.value});

    console.log("queryObject ==>", this.queryObject);
    this.updateListPage();
  }

  applyRangeFilter(filter){
    this.queryObject.min_price = filter.value.start;
    this.queryObject.max_price = filter.value.end;
    console.log("queryObject ==>", this.queryObject);
    this.updateListPage();
  }

  updateListPage(){
    this.isMobile ? this.getFiltersCount() : this.callListPageApi();
  }

  resetFilters(){
    this.filters = Object.assign([], this.filtersCopy);
    console.log("on reset filter ==>", this.filters)
    this.mobilefilter = false;
  }

}
