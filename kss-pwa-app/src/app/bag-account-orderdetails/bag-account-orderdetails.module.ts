import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BagSummaryModule } from '../shared-components/bag-summary/bag-summary.module';

import { OrderInfoComponent } from './components/order-info/order-info.component';
import { OrderComponent } from './components/order/order.component';
import { ShippingAddressComponent } from './components/shipping-address/shipping-address.component';
import { PaymentInfoComponent } from './components/payment-info/payment-info.component';
import { OrderSummaryComponent } from './components/order-summary/order-summary.component';
import { ItemComponent } from './components/item/item.component';

@NgModule({
  declarations: [
  	OrderInfoComponent,
  	OrderComponent,
  	ShippingAddressComponent,
  	PaymentInfoComponent,
  	OrderSummaryComponent,
  	ItemComponent
  ],
  imports: [
    CommonModule,
    BagSummaryModule
  ],
  exports: [
    OrderInfoComponent,
    OrderComponent,
    ShippingAddressComponent,
    PaymentInfoComponent,
    OrderSummaryComponent,
    ItemComponent
  ]
})
export class BagAccountOrderdetailsModule { }
