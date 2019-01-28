import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AccountRoutingModule } from './account-routing.module';
import { AccountComponent } from './account/account.component';
import { MyOrdersComponent } from './my-orders/my-orders.component';
import { OrderDetailsComponent } from './order-details/order-details.component';
import { MyAddressesComponent } from './my-addresses/my-addresses.component';
import { MyProfileComponent } from './my-profile/my-profile.component';

import { BagSummaryModule } from '../shared-components/bag-summary/bag-summary.module';
import { AddressModule } from '../shared-components/address/address.module';
import { EditUserModule } from '../shared-components/edit-user/edit-user.module';

import { OrderInfoComponent } from './components/order-info/order-info.component';
import { OrderComponent } from './components/order/order.component';
import { ShippingAddressComponent } from './components/shipping-address/shipping-address.component';
import { PaymentInfoComponent } from './components/payment-info/payment-info.component';
import { OrderSummaryComponent } from './components/order-summary/order-summary.component';

import { AccountService } from './services/account.service';

@NgModule({
  imports: [
    CommonModule,
    AccountRoutingModule,
    BagSummaryModule,
    AddressModule,
    EditUserModule
  ],
  declarations: [
  	AccountComponent, 
  	MyOrdersComponent, 
  	OrderDetailsComponent,
  	OrderInfoComponent,
  	OrderComponent,
  	ShippingAddressComponent,
  	PaymentInfoComponent,
  	OrderSummaryComponent,
  	MyAddressesComponent,
  	MyProfileComponent
  ],
  providers: [
    AccountService
  ]
})
export class AccountModule { }
