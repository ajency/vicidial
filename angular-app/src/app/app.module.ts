import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {APP_BASE_HREF} from '@angular/common';
import { HttpModule }    from '@angular/http';

import { AppRoutingModule }     from './app-routing.module';

import { AppComponent } from './app.component';
import { CartComponent } from './pages/cart/cart.component';
import { ShippingDetailsComponent } from './pages/shipping-details/shipping-details.component';
import { ShippingSummaryComponent } from './pages/shipping-summary/shipping-summary.component';

import { AppServiceService } from './service/app-service.service';
import { ApiServiceService } from './service/api-service.service';
import { NumbersDirective } from './directives/numbers.directive';

import { LoginModule } from './shared-components/login/login.module';



@NgModule({
  declarations: [
    AppComponent,
    CartComponent,
    ShippingDetailsComponent,
    ShippingSummaryComponent,
    NumbersDirective
  ],
  imports: [
    BrowserModule,
    FormsModule,
    AppRoutingModule,
    HttpModule,
    LoginModule
  ],
  providers: [
    {provide: APP_BASE_HREF, useValue: '/'},
    AppServiceService,
    ApiServiceService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
