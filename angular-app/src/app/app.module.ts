import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {APP_BASE_HREF} from '@angular/common';
import { HttpModule }    from '@angular/http';
import {HashLocationStrategy, Location, LocationStrategy} from '@angular/common';

import { AppRoutingModule }     from './app-routing.module';

import { AppComponent } from './app.component';

import { AppServiceService } from './service/app-service.service';
import { ApiServiceService } from './service/api-service.service';
import { AuthGuardService } from './service/auth-guard.service';
import { NumbersDirective } from './directives/numbers.directive';

import { LoginModule } from './shared-components/login/login.module';
import { PromotionsModule } from './shared-components/promotions/promotions.module';
// import { AppliedCouponComponent } from './components/applied-coupon/applied-coupon.component';
// import { UpgradeCartComponent } from './components/upgrade-cart/upgrade-cart.component';
// import { BetterPromoAvailableComponent } from './components/better-promo-available/better-promo-available.component';

import { BagSummaryModule } from './shared-components/bag-summary/bag-summary.module';
// import { BagModule } from './bag/bag.module';

@NgModule({
  declarations: [
    AppComponent,
    NumbersDirective
  ],
  imports: [
    BrowserModule,
    FormsModule,
    AppRoutingModule,
    HttpModule,
    LoginModule,
    PromotionsModule,
    BagSummaryModule
  ],
  providers: [
    {provide: LocationStrategy, useClass: HashLocationStrategy},
    AppServiceService,
    ApiServiceService,
    AuthGuardService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
