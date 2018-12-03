import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { MyOrdersComponent } from './pages/my-orders/my-orders.component';
import { AccountComponent } from './pages/account/account.component';


const routes: Routes = [
	{ path: 'account', component: AccountComponent}
	{ path: 'account/my-orders', component: MyOrdersComponent }
	{ path: '', redirectTo: 'account/my-orders', pathMatch: 'full' }
];

@NgModule({
  imports: [ RouterModule.forRoot(routes)],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}
