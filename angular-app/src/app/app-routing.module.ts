import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { LoginComponent } from './login/login.component';

const routes: Routes = [
	{ path: 'user-login', component : LoginComponent, outlet: 'popup'},
	{ path: 'bag', loadChildren: './bag/bag.module#BagModule' },
	{ path: 'account', loadChildren: './account/account.module#AccountModule'}
];

@NgModule({
  imports: [ RouterModule.forRoot(routes)],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}
