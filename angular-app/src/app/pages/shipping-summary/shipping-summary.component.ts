import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router'
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';


@Component({
  selector: 'app-shipping-summary',
  templateUrl: './shipping-summary.component.html',
  styleUrls: ['./shipping-summary.component.css']
})
export class ShippingSummaryComponent implements OnInit {

  shippingDetails : any;
  constructor(private router : Router,
  			   		private appservice : AppServiceService,
              private apiservice : ApiServiceService
  					) { }

  ngOnInit() {
    this.shippingDetails = this.appservice.shippingDetails;
    console.log("this.shippingDetails ==>", this.shippingDetails);
    this.appservice.updateCartId();
    this.updateUrl();
  }

  navigateToPaymentPage(){
  	// this.router.navigateByUrl('/payment', { skipLocationChange: true });
    window.location.href = "/user/order/" + this.shippingDetails.order_id +"/payment/payu";
  }
  
  closeCart(){
    console.log("history.lenght ==>", history.length);
    this.appservice.cartClosedFromShippingPages = true;
    if(history.length > 3)
      history.go(-3);
    else{
      // history.go(-2);
      let url = window.location.href.split("#")[0];
      history.replaceState({cart : false}, 'cart', url);
      this.appservice.closeCart();
      this.router.navigateByUrl('/cartpage', {skipLocationChange: true});
    }
  }

  navigateBack(){
    console.log("history.lenght ==>", history.length);
    if(history.length > 3)
      history.go(-2);
    else{
      history.back();
    }
  }

  updateUrl(){
    let url = window.location.href.split("#")[0] + '#shipping-summary';
    console.log("check url ==>", url);
    history.pushState({cart : true}, 'cart', url);      
  }

}
