import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router'
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-shipping-summary',
  templateUrl: './shipping-summary.component.html',
  styleUrls: ['./shipping-summary.component.css']
})
export class ShippingSummaryComponent implements OnInit {

  shippingDetails : any;
  constructor( private router : Router,
  			   		 private appservice : AppServiceService
  					) { }

  ngOnInit() {
    this.shippingDetails = this.appservice.shippingDetails;
    console.log("this.shippingDetails ==>", this.shippingDetails);
  }

  navigateToPaymentPage(){
  	this.router.navigateByUrl('/payment', { skipLocationChange: true });
  }
  
  closeCart(){
    this.appservice.closeCart();
  }

}
