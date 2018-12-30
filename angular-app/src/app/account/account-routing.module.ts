import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AccountComponent } from './account/account.component';
import { MyOrdersComponent } from './my-orders/my-orders.component';
import { OrderDetailsComponent } from './order-details/order-details.component';
import { MyAddressesComponent } from './my-addresses/my-addresses.component';
import { MyProfileComponent } from './my-profile/my-profile.component';

import { AuthGuardService as AuthGuard } from '../service/auth-guard.service';

const routes: Routes = [
	{ path: '', component: AccountComponent},
	{ path: 'my-orders', component: MyOrdersComponent},
	{ path: 'my-orders/:id', component: OrderDetailsComponent},
	{ path: 'my-addresses', component: MyAddressesComponent},
	{ path: 'my-profile', component: MyProfileComponent}
	{ path: '**' , redirectTo: 'account'}
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AccountRoutingModule { }
