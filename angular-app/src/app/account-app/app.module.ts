import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpModule }    from '@angular/http';

import { AppComponent } from './app.component';
import {HashLocationStrategy, Location, LocationStrategy} from '@angular/common';

import { AppRoutingModule }     from './app-routing.module';
import { MyOrdersComponent } from './pages/my-orders/my-orders.component';

import { ApiServiceService } from './services/api-service.service';
import { AppServiceService } from './services/app-service.service';
import { AccountComponent } from './pages/account/account.component';

import { LoginModule } from '../shared-components/login/login.module';
import { AuthGuardService } from './services/auth-guard.service';
import { BagSummaryModule } from '../shared-components/bag-summary/bag-summary.module';
import { OrderDetailsComponent } from './pages/order-details/order-details.component';
import { OrderInfoComponent } from './components/order-info/order-info.component';
import { OrderComponent } from './components/order/order.component';
import { ShippingAddressComponent } from './components/shipping-address/shipping-address.component';
import { PaymentInfoComponent } from './components/payment-info/payment-info.component';
import { OrderSummaryComponent } from './components/order-summary/order-summary.component';

@NgModule({
  declarations: [
    AppComponent,
    MyOrdersComponent,
    AccountComponent,
    OrderDetailsComponent,
    OrderInfoComponent,
    OrderComponent,
    ShippingAddressComponent,
    PaymentInfoComponent,
    OrderSummaryComponent
    // LoginComponentComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpModule,
    LoginModule,
    BagSummaryModule
  ],
  providers: [
     Location, 
     {provide: LocationStrategy, useClass: HashLocationStrategy},
     ApiServiceService,
     AppServiceService,
     AuthGuardService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }