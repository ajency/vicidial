import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AccountRoutingModule } from './account-routing.module';
import { AccountComponent } from './account/account.component';
import { MyOrdersComponent } from './my-orders/my-orders.component';
import { OrderDetailsComponent } from './order-details/order-details.component';

// import { LoginModule } from '../shared-components/login/login.module';
import { BagSummaryModule } from '../shared-components/bag-summary/bag-summary.module';


import { OrderInfoComponent } from './components/order-info/order-info.component';
import { OrderComponent } from './components/order/order.component';
import { ShippingAddressComponent } from './components/shipping-address/shipping-address.component';
import { PaymentInfoComponent } from './components/payment-info/payment-info.component';
import { OrderSummaryComponent } from './components/order-summary/order-summary.component';

@NgModule({
  imports: [
    CommonModule,
    AccountRoutingModule,
    BagSummaryModule
  ],
  declarations: [
  	AccountComponent, 
  	MyOrdersComponent, 
  	OrderDetailsComponent,
  	OrderInfoComponent,
  	OrderComponent,
  	ShippingAddressComponent,
  	PaymentInfoComponent,
  	OrderSummaryComponent
  ]
})
export class AccountModule { }
