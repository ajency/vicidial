import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { MyOrdersComponent } from './pages/my-orders/my-orders.component';
import { BlankComponent } from './pages/blank/blank.component';

// import { ShippingDetailsComponent } from './pages/shipping-details/shipping-details.component';
// import { ShippingSummaryComponent } from './pages/shipping-summary/shipping-summary.component';
// import { PaymentComponent } from './pages/payment/payment.component';


const routes: Routes = [
	{ path: 'my-orders', component: MyOrdersComponent},
	{ path: 'blank', component: BlankComponent}
];

@NgModule({
  imports: [ RouterModule.forRoot(routes)],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}
