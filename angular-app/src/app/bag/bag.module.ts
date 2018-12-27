import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule }   from '@angular/forms';

import { BagRoutingModule } from './bag-routing.module';
import { ShippingDetailsComponent } from './shipping-details/shipping-details.component';
import { ShippingSummaryComponent } from './shipping-summary/shipping-summary.component';
import { BagViewComponent } from './bag-view/bag-view.component';

import { BagSummaryModule } from '../shared-components/bag-summary/bag-summary.module';
import { PromotionsModule } from '../shared-components/promotions/promotions.module';

import { AppliedCouponComponent } from '../components/applied-coupon/applied-coupon.component';
import { UpgradeCartComponent } from '../components/upgrade-cart/upgrade-cart.component';
import { BetterPromoAvailableComponent } from '../components/better-promo-available/better-promo-available.component';

// import { LoginModule } from '../shared-components/login/login.module';

@NgModule({
  imports: [
    CommonModule,
    BagRoutingModule,
    FormsModule,
    BagSummaryModule,
    PromotionsModule
  ],
  declarations: [ShippingDetailsComponent, 
  				ShippingSummaryComponent, 
  				BagViewComponent,
  				AppliedCouponComponent,
  				UpgradeCartComponent,
  				BetterPromoAvailableComponent]
})
export class BagModule { }
