import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ComponentsModule } from '../components/components.module';
import { BagAccountOrderdetailsModule } from '../bag-account-orderdetails/bag-account-orderdetails.module';

import { OrderDetailsRoutingModule } from './order-details-routing.module';
import { OrderDetailsPageComponent } from './order-details-page/order-details-page.component';
import { OrderMessageComponent } from './component/order-message/order-message.component';
// import { OrderInfoComponent } from './component/order-info/order-info.component';
// import { OrderComponent } from './component/order/order.component';
import { OrderSidebarComponent } from './component/order-sidebar/order-sidebar.component';

@NgModule({
  declarations: [OrderDetailsPageComponent, OrderMessageComponent, OrderSidebarComponent],
  imports: [
    CommonModule,
    OrderDetailsRoutingModule,
    ComponentsModule,
    BagAccountOrderdetailsModule
  ]
})
export class OrderDetailsModule { }
