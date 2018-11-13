import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router'
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
declare var $: any;


@Component({
  selector: 'app-shipping-summary',
  templateUrl: './shipping-summary.component.html',
  styleUrls: ['./shipping-summary.component.css']
})
export class ShippingSummaryComponent implements OnInit {

  shippingDetails : any;
  constructor(private router : Router,
  			   		private appservice : AppServiceService,
              private apiservice : ApiServiceService,
              private route : ActivatedRoute
  					) { }

  ngOnInit() {
    // this.shippingDetails = this.appservice.shippingDetails;
    // console.log("this.shippingDetails ==>", this.shippingDetails);
    // this.appservice.updateCartId();
    if(this.appservice.continueOrder){
      this.appservice.continueOrder = false;
      this.callContinueOrderApi();
    }
    else
      this.callCreateOrderApi();
    this.updateUrl();
  }

  navigateToPaymentPage(){
  	// this.router.navigateByUrl('/payment', { skipLocationChange: true });
    window.location.href = "/user/order/" + this.shippingDetails.order_id +"/payment/payu";
  }
  
  closeCart(){
    let url = window.location.href.split("#")[0];
    history.pushState({cart : false}, 'cart', url);
    window.location.reload();
    // console.log("history.lenght ==>", history.length);
    // this.appservice.cartClosedFromShippingPages = true;
    // if(history.length > 3)
    //   history.go(-3);
    // else{
    //   // history.go(-2);
    //   let url = window.location.href.split("#")[0];
    //   history.replaceState({cart : false}, 'cart', url);
    //   this.appservice.closeCart();
    //   this.router.navigateByUrl('/cartpage', {skipLocationChange: true});
    // }
  }

  navigateBack(){
    history.back();
    // console.log("history.lenght ==>", history.length);
    // if(history.length > 3)
    //   history.go(-2);
    // else{
    //   history.back();
    // }
  }

  updateUrl(){
    let url = window.location.href.split("#")[0] + '#shipping-summary';
    console.log("check url ==>", url);
    history.pushState({cart : true}, 'cart', url);      
  }

  callCreateOrderApi(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + '/api/rest/v1/user/cart/' + this.appservice.getCookie('cart_id') + '/create-order'
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      address_id : this.appservice.selectedAddressId
    };
    body._token = $('meta[name="csrf-token"]').attr('content');

    this.apiservice.request(url, 'post', body , header ).then((response)=>{
      this.shippingDetails = this.getProductUrl(response);
      this.appservice.removeLoader();
      // this.appservice.updateCartId();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
    })  
  }

  callContinueOrderApi(){
    this.appservice.showLoader();
     '/api/rest/v1/user/cart/{id}/continue-order'

    let url = this.appservice.apiUrl + '/api/rest/v1/user/cart/' + this.appservice.getCookie('cart_id') + '/continue-order';
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      _token : $('meta[name="csrf-token"]').attr('content')
    };

    this.apiservice.request(url, 'post', body , header ).then((response)=>{
      this.shippingDetails = this.getProductUrl(response);
      this.appservice.removeLoader();
      // this.appservice.updateCartId();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
    })  
  }

  getProductUrl(data){
    data.items.forEach((item)=>{
      item.href = '/' + item.product_slug +'/buy?size='+item.attributes.size;
      item.attributes.images = Array.isArray(item.attributes.images) ? ['/img/placeholder.svg', '/img/placeholder.svg', '/img/placeholder.svg'] : Object.values(item.attributes.images);
    })
    return data;
  }

}
