import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-shipping-details',
  templateUrl: './shipping-details.component.html',
  styleUrls: ['./shipping-details.component.css']
})
export class ShippingDetailsComponent implements OnInit {

	addAddress = false;
  constructor( private router : Router,
               private appservice : AppServiceService
            ) { }

  ngOnInit() {
  }

  navigateToShippingPage(){
  	this.router.navigateByUrl('/shipping-summary', { skipLocationChange: true })
  }

  closeCart(){
    this.appservice.closeCart();
  }
}
