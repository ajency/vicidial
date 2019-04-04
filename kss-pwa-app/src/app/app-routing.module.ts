import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { WidgetComponent } from './widget/widget.component';
import { RouteGuardService as RouteGuard } from './services/route-guard.service';

const routes: Routes = [	
	{ path: '',  loadChildren: './home/home.module#HomeModule'},
	{ path: 'drafthome',  loadChildren: './home/home.module#HomeModule'},
	{ path: ':product_slug/buy',  loadChildren: './product-page/product-page.module#ProductPageModule'},
	{ path: 'shop', loadChildren : './shop-page/shop-page.module#ShopPageModule' },
	{ path: 'shop/uniforms',  loadChildren: './landing-page/landing-page.module#LandingPageModule'},
	{ path: '**', component : WidgetComponent }	
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {scrollPositionRestoration : 'top'})],
  exports: [RouterModule]
})
export class AppRoutingModule { }
