import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { WidgetComponent } from './widget/widget.component';
import { RouteGuardService as RouteGuard } from './services/route-guard.service';

const routes: Routes = [	
	{ path: '',  loadChildren: './home/home.module#HomeModule'},
	{ path: 'drafthome',  loadChildren: './home/home.module#HomeModule'},
	{ path: 'contact-us', component : WidgetComponent },
	{ path: 'contact', component : WidgetComponent },
	{ path: 'faq', component : WidgetComponent },
	{ path: 'about-us', component : WidgetComponent },
	{ path: 'terms-and-conditions', component : WidgetComponent },
	{ path: 'privacy-policy', component : WidgetComponent },
	{ path: 'ideas', component : WidgetComponent },
	{ path: 'ideas/:title', component : WidgetComponent },
	{ path: 'ideas/category/:category', component : WidgetComponent },
	{ path: 'stores', component : WidgetComponent },
	{ path: 'stores/surat', component : WidgetComponent },
	{ path: 'stores/hyderabad', component : WidgetComponent },
	{ path: 'stores/coimbatore', component : WidgetComponent },
	{ path: 'stores/jaipur', component : WidgetComponent },
	{ path: 'activities/:storename', component : WidgetComponent },
	{ path: 'my/order/details', component : WidgetComponent },
	{ path: 'shop', loadChildren : './shop-page/shop-page.module#ShopPageModule' },
	{ path: 'newshop', loadChildren : './shop-page/shop-page.module#ShopPageModule' },
	{ path: 'shop/uniforms',  loadChildren: './landing-page/landing-page.module#LandingPageModule'},
	{ path: 'shop/:gendername', component : WidgetComponent },
	{ path: 'draft/:gendername', component : WidgetComponent },
	{ path: ':product_slug/buy',  loadChildren: './product-page/product-page.module#ProductPageModule'},
	{ path: ':cat1', loadChildren : './shop-page/shop-page.module#ShopPageModule'},
	{ path: ':cat1/:cat2', loadChildren : './shop-page/shop-page.module#ShopPageModule'},
	{ path: ':cat1/:cat2/:cat3', loadChildren : './shop-page/shop-page.module#ShopPageModule'},
	{ path: ':cat1/:cat2/:cat3/:cat4', loadChildren : './shop-page/shop-page.module#ShopPageModule'},
	{ path: '**', component : WidgetComponent }	
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {scrollPositionRestoration : 'top'})],
  exports: [RouterModule]
})
export class AppRoutingModule { }
