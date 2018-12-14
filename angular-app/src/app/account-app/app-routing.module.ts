import { NgModule } from '@angular/core';
import { RouterModule, Routes, CanActivate } from '@angular/router';

import { MyOrdersComponent } from './pages/my-orders/my-orders.component';
import { AccountComponent } from './pages/account/account.component';
import { OrderDetailsComponent } from './pages/order-details/order-details.component';

import { AuthGuardService as AuthGuard } from './services/auth-guard.service';

const routes: Routes = [
	{ path: 'account', component: AccountComponent},
	{ path: 'account/my-orders', component: MyOrdersComponent, canActivate: [AuthGuard] },
	{ path: 'account/my-orders/:id', component: OrderDetailsComponent, canActivate: [AuthGuard] },
	{ path: '**' , redirectTo: 'account'}
	// { path: '', redirectTo: 'account/my-orders', pathMatch: 'full' }
];

@NgModule({
  imports: [ RouterModule.forRoot(routes)],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}
