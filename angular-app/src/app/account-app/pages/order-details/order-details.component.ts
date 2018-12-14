import { Component, OnInit } from '@angular/core';
import { OrderInfoComponent } from '../../components/order-info/order-info.component';
import { OrderComponent } from '../../components/order/order.component';
import { ShippingAddressComponent } from '../../components/shipping-address/shipping-address.component';
import { PaymentInfoComponent } from '../../components/payment-info/payment-info.component';
import { OrderSummaryComponent } from '../../components/order-summary/order-summary.component';

import { AppServiceService } from '../../services/app-service.service';
import { ApiServiceService } from '../../services/api-service.service';

@Component({
  selector: 'app-order-details',
  templateUrl: './order-details.component.html',
  styleUrls: ['./order-details.component.css']
})

export class OrderDetailsComponent implements OnInit {
  
  order : any;
  
  constructor(private appservice : AppServiceService) { }
  
  ngOnInit() {
    this.order =  this.appservice.order;
  }

  closeWidget(){
    
  }

}
