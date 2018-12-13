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

@NgModule({
  declarations: [
    AppComponent,
    MyOrdersComponent,
    AccountComponent
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