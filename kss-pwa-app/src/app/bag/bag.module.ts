import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule }   from '@angular/forms';

// import { BagRoutingModule } from './bag-routing.module';
import { ShippingDetailsComponent } from './shipping-details/shipping-details.component';
import { ShippingSummaryComponent } from './shipping-summary/shipping-summary.component';
import { BagViewComponent } from './bag-view/bag-view.component';

import { BagSummaryModule } from '../shared-components/bag-summary/bag-summary.module';
import { PromotionsModule } from '../shared-components/promotions/promotions.module';
import { AddressModule } from '../shared-components/address/address.module';
import { EditUserModule } from '../shared-components/edit-user/edit-user.module';

import { AppliedCouponComponent } from './components/applied-coupon/applied-coupon.component';
import { UpgradeCartComponent } from './components/upgrade-cart/upgrade-cart.component';
import { BetterPromoAvailableComponent } from './components/better-promo-available/better-promo-available.component';
import { VerifyCodComponent } from './verify-cod/verify-cod.component';
import { NavbarComponent } from './components/navbar/navbar.component';


@NgModule({
  imports: [
    CommonModule,
    // BagRoutingModule,
    FormsModule,
    BagSummaryModule,
    PromotionsModule,
    AddressModule,
    EditUserModule
  ],
  declarations: [ShippingDetailsComponent, 
  				ShippingSummaryComponent, 
  				BagViewComponent,
  				AppliedCouponComponent,
  				UpgradeCartComponent,
  				BetterPromoAvailableComponent,
  				VerifyCodComponent,
  				NavbarComponent],
  entryComponents: [BagViewComponent],
  bootstrap: [BagViewComponent]
})
export class BagModule { }
