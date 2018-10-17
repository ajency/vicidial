import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router'
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-shipping-summary',
  templateUrl: './shipping-summary.component.html',
  styleUrls: ['./shipping-summary.component.css']
})
export class ShippingSummaryComponent implements OnInit {

  constructor( private router : Router,
  			   		 private appservice : AppServiceService
  					) { }

  ngOnInit() {
  }

  navigateToPaymentPage(){
  	this.router.navigateByUrl('/payment', { skipLocationChange: true });
  }
  
  closeCart(){
    this.appservice.closeCart();
  }

}
