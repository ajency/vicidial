import { Component, OnInit, isDevMode } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';
import {BreakpointObserver, Breakpoints} from '@angular/cdk/layout';

declare var fbTrackViewContent : any;
declare var gtagTrackPageView : any;

@Component({
  selector: 'app-product-page',
  templateUrl: './product-page.component.html',
  styleUrls: ['./product-page.component.scss']
})
export class ProductPageComponent implements OnInit {

	product : any;
  showLoader : boolean = false;
  menuObject : any
  isMobile : boolean = false;
  queryParamSize : any;
  inventoryData : any;
  productApiCall : any;
  inventoryApiCall : any;
  constructor(private route: ActivatedRoute,
  			  private apiService: ApiServiceService,
              private appservice : AppServiceService,
              private breakpointObserver : BreakpointObserver) {
    this.isMobile = this.breakpointObserver.isMatched('(max-width: 600px)');
   }

  ngOnInit() {
    this.route.params.subscribe(routeParams => {
      console.log("routeParams ==>", routeParams);
      this.showLoader = true;
      this.product = [];
      this.product.facets = [];
      this.product.variants = [];
      this.product.related_products = [1,2,3,4,5];
      this.product.breadcrumbs = []
      this.product.size_chart = {};
      this.product.attributes = {};
      this.getProductDetails(routeParams.product_slug);
    });
  }

  ngOnDestroy() {
    this.unsubscribeProductApi();
    this.unsubscribeInventoryApiCall();
  }

  getProductDetails(product_slug){
    // let product_slug = this.route.snapshot.paramMap.get('product_slug');
    this.unsubscribeProductApi();
    this.queryParamSize = this.route.snapshot.queryParamMap.get('size');
    let url = isDevMode() ? "https://demo8558685.mockable.io/get_single_product" : this.appservice.apiUrl + '/api/rest/v1/single-product?slug='+product_slug;
    this.productApiCall = this.apiService.request(url,'get',{},{}, false, 'observable').subscribe((data)=>{
      this.loadCart();
      this.product = data;
      if(this.product.is_sellable)
        this.checkSingleProductInventory();
      let variant = this.product.variants.find((v)=>{ return this.queryParamSize == v.variant_facets.variant_size.name});
      let default_price;
      if(variant)
        default_price =  variant.variant_attributes.variant_sale_price;
      else{
        variant = this.product.variants.find((v)=>{ return v.is_default === true })
        default_price = variant.variant_attributes.variant_sale_price;
      }

      fbTrackViewContent(default_price, this.product.attributes.product_id, this.product.facets.product_color_html.id);
      gtagTrackPageView(default_price, this.product.attributes.product_id, this.product.facets.product_color_html.id);
      this.showLoader = false;
      console.log("response ==>", data);
    },
    (error)=>{
      console.log("error in fetching the json",error);
      this.showLoader = false;
      this.product = null;
    });
  }

  checkSingleProductInventory(){
    this.unsubscribeInventoryApiCall();
    let url = this.appservice.apiUrl + '/api/rest/v1/single-product-inventory?product_id='+this.product.attributes.product_id + '&color_id='+ this.product.facets.product_color_html.id;
    this.inventoryApiCall = this.apiService.request(url, 'get', {} , {}, false, 'observable').subscribe((response)=>{
      console.log("check inventory response ==>", response);
      this.inventoryData = response;
    },
    (error)=>{
      console.log("error ===>", error);
    });
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  getOffPercentage(list_price, sale_price){
    return this.appservice.calculateOff(list_price, sale_price);
  }

  loadCart(){
    if(window.location.href.endsWith('#/bag') || window.location.href.endsWith('#/bag/shipping-address') || window.location.href.endsWith('#/bag/shipping-summary')){
      this.appservice.loadCartFromAngular = true;
      this.appservice.loadCartTrigger();
    }
    else if(window.location.href.endsWith('#/account') || window.location.href.endsWith('#/account/my-orders') || window.location.href.includes('#/account/my-orders/')){
      this.appservice.loadAccountFromAngular = true;
      this.appservice.loadCartTrigger();
    }        
  }

  unsubscribeProductApi(){
    if(this.productApiCall)
      this.productApiCall.unsubscribe();
  }

  unsubscribeInventoryApiCall(){
    if(this.inventoryApiCall)
      this.inventoryApiCall.unsubscribe();
  }
}
