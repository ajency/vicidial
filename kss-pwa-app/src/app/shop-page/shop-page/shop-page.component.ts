import { Component, OnInit, isDevMode } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-shop-page',
  templateUrl: './shop-page.component.html',
  styleUrls: ['./shop-page.component.scss']
})
export class ShopPageComponent implements OnInit {

  listApiCall : any;
  listPage : any;
  showLoader : boolean = false;
  sortOn : any = 'recommended';
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
  constructor(private apiService: ApiServiceService,
              private appservice : AppServiceService,
              private route: ActivatedRoute,) { }

  ngOnInit() {
    this.callListPageApi();
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
    this.showLoader = true;
    this.unsubscribeListPageApi();
    let url = isDevMode() ? "https://demo8558685.mockable.io/product-list" : this.appservice.apiUrl + '/api/rest/v1/product-list';
    url = "https://demo8558685.mockable.io/product-list";
    this.listApiCall = this.apiService.request(url, 'get', {} , {}, false, 'observable').subscribe((response)=>{
      response.items.forEach(item=>{
        item.url = '/'+item.attributes.product_slug+'/buy';
        item.image = item.images[0].main;
        item.title = item.attributes.product_title;
        let default_variant = item.variants.find((variant)=>{return variant.is_default === true});
        item.sale_price = default_variant.variant_attributes.variant_sale_price;
        item.list_price = default_variant.variant_attributes.variant_list_price;
      })
      this.listPage = response;
      this.showLoader = false;
      console.log("check inventory response ==>",this.listPage);
    },
    (error)=>{
      console.log("error ===>", error);
      this.showLoader = false;
    });
  }

  unsubscribeListPageApi(){
    if(this.listApiCall)
      this.listApiCall.unsubscribe();
  }

  applyFilter(search_text){
    console.log("applyFilter", search_text);
  }

  sortBy(){
    console.log("sortBy ==>", this.sortOn);
  }

}
