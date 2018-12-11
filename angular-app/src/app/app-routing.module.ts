import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { CartComponent } from './pages/cart/cart.component';
import { ShippingDetailsComponent } from './pages/shipping-details/shipping-details.component';
import { ShippingSummaryComponent } from './pages/shipping-summary/shipping-summary.component';


const routes: Routes = [
	{ path: 'shipping-details', component: ShippingDetailsComponent},
	{ path: 'shipping-summary', component: ShippingSummaryComponent},
	{ path: '**', component: CartComponent }
];

@NgModule({
  imports: [ RouterModule.forRoot(routes)],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}
