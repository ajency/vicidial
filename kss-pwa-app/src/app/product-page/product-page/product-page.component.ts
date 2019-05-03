import { Component, OnInit, isDevMode } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';
import {BreakpointObserver, Breakpoints} from '@angular/cdk/layout';
import { Location } from '@angular/common';
import { Router } from '@angular/router';

declare var fbTrackViewContent : any;
declare var gtagTrackPageView : any;
declare var runMicrodataScript : any;

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
              private breakpointObserver : BreakpointObserver,
              private location: Location,
              private router: Router) {
    this.isMobile = this.breakpointObserver.isMatched('(max-width: 991px)');
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
      this.product = data;
      let variant = this.product.variants.find((v)=>{ return this.queryParamSize == v.variant_facets.variant_size.name});
      let default_price;
      if(variant)
        default_price =  variant.variant_attributes.variant_sale_price;
      else{
        variant = this.product.variants.find((v)=>{ return v.is_default === true })
        default_price = variant.variant_attributes.variant_sale_price;
      }
      if(this.product.is_sellable)
        this.checkSingleProductInventory(default_price);
      this.showLoader = false;
      try {
        fbTrackViewContent(default_price, this.product.attributes.product_id, this.product.facets.product_color_html.id);
        gtagTrackPageView(default_price, this.product.attributes.product_id, this.product.facets.product_color_html.id);
        if(!this.product.is_sellable)
          runMicrodataScript(this.product, default_price,false);
      } catch (e) {
        console.log("error in fb or gtag tracking ==>", e);
      }
    },
    (error)=>{
      console.log("error in fetching the json",error);
      this.showLoader = false;
      this.product = null;
    });
  }

  checkSingleProductInventory(default_price){
    this.unsubscribeInventoryApiCall();
    let url = this.appservice.apiUrl + '/api/rest/v1/single-product-inventory?product_id='+this.product.attributes.product_id + '&color_id='+ this.product.facets.product_color_html.id;
    this.inventoryApiCall = this.apiService.request(url, 'get', {} , {}, false, 'observable').subscribe((response)=>{
      console.log("check inventory response ==>", response);
      this.inventoryData = response;
      let in_stock = false;
      // for(const [key, value] of Object.entries(this.inventoryData.variants)) {
      //   if(value > 0)
      //     in_stock = true;
      // }
      for (const key in this.inventoryData.variants) {
        if(this.inventoryData.variants[key] > 0)
          in_stock = true;
      }
      try {
        in_stock ? runMicrodataScript(this.product, default_price,true) : runMicrodataScript(this.product, default_price,false);;  
      }
      catch (e) {
        console.log("error in runMicrodataScript function", e);
      }
      
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

  unsubscribeProductApi(){
    if(this.productApiCall)
      this.productApiCall.unsubscribe();
  }

  unsubscribeInventoryApiCall(){
    if(this.inventoryApiCall)
      this.inventoryApiCall.unsubscribe();
  }

  backToPrev(){
    if (window.history.length > 2) {
      this.location.back()
    } else {
      this.router.navigate(['/'])
    }
  }
}
