import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpModule }    from '@angular/http';

import { AppComponent } from './app.component';
import {HashLocationStrategy, Location, LocationStrategy} from '@angular/common';

import { AppRoutingModule }     from './app-routing.module';
import { MyOrdersComponent } from './pages/my-orders/my-orders.component';
import { BlankComponent } from './pages/blank/blank.component';

import { ApiServiceService } from './services/api-service.service';
import { AppServiceService } from './services/app-service.service';


@NgModule({
  declarations: [
    AppComponent,
    MyOrdersComponent,
    BlankComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpModule
  ],
  providers: [
     Location, 
     {provide: LocationStrategy, useClass: HashLocationStrategy},
     ApiServiceService,
     AppServiceService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }