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
  constructor(private route: ActivatedRoute,
  			  private apiService: ApiServiceService,
              private appservice : AppServiceService,
              private breakpointObserver : BreakpointObserver) {
    this.isMobile = this.breakpointObserver.isMatched('(max-width: 600px)');
   }

  ngOnInit() {
    this.getMenu();
    this.getProductDetails();
  }

  getProductDetails(){
    this.showLoader = true;
    let product_slug = this.route.snapshot.paramMap.get('product_slug');
    this.queryParamSize = this.route.snapshot.queryParamMap.get('size');
    let url = isDevMode() ? "https://demo8558685.mockable.io/get_single_product" : this.appservice.apiUrl + '/api/rest/v1/single-product?slug='+product_slug;
    this.apiService.request(url,'get',{},{}).then((data)=>{
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
    })
    .catch((error)=>{
      console.log("error in fetching the json",error);
      this.showLoader = false;
    })
  }

  checkSingleProductInventory(){
    let url = this.appservice.apiUrl + '/api/rest/v1/single-product-inventory?product_id='+this.product.attributes.product_id + '&color_id='+ this.product.facets.product_color_html.id;
    this.apiService.request(url, 'get', {} , {}).then((response)=>{
      console.log("check inventory response ==>", response);
      this.inventoryData = response;
    })
    .catch((error)=>{
      console.log("error ===>", error);
    })
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  getOffPercentage(list_price, sale_price){
    return this.appservice.calculateOff(list_price, sale_price);
  }

  getMenu(){
    let url = isDevMode() ? "https://demo8558685.mockable.io/get-menu" : "/api/rest/v1/test/get-menu"
    this.apiService.request(url,'get',{},{}).then((data)=>{
      console.log("data ==>", data);
      this.menuObject = data.menu;
    })
    .catch((error)=>{
      console.log("error in fetching the json",error);
    })
  }
}
