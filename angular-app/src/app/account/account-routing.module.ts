import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AccountComponent } from './account/account.component';
import { MyOrdersComponent } from './my-orders/my-orders.component';
import { OrderDetailsComponent } from './order-details/order-details.component';

import { AuthGuardService as AuthGuard } from '../service/auth-guard.service';

const routes: Routes = [
	{ path: '', component: AccountComponent},
	{ path: 'my-orders', component: MyOrdersComponent, canActivate: [AuthGuard] },
	{ path: 'my-orders/:id', component: OrderDetailsComponent, canActivate: [AuthGuard] },
	{ path: '**' , redirectTo: 'account'}
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AccountRoutingModule { }
