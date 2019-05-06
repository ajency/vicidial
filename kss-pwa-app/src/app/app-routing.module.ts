import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { WidgetComponent } from './widget/widget.component';
import { RouteGuardService as RouteGuard } from './services/route-guard.service';

const routes: Routes = [
	{ path: '',  loadChildren: './home/home.module#HomeModule'},
	{ path: 'drafthome',  loadChildren: './home/home.module#HomeModule'},

	{ path: 'about-us',  loadChildren: './about-us/about-us.module#AboutUsModule'},
	{ path: 'privacy-policy',  loadChildren: './privacy-policy/privacy-policy.module#PrivacyPolicyModule'},
	{ path: 'terms-and-conditions',  loadChildren: './terms-and-conditions/terms-and-conditions.module#TermsAndConditionsModule'},
	{ path: 'faq',  loadChildren: './faq/faq.module#FaqModule'},
	{ path: 'contact',  loadChildren: './contact-us/contact-us.module#ContactUsModule'},
	{ path: 'stores',  loadChildren: './stores/stores.module#StoresModule'},

	{ path: 'ideas', component : WidgetComponent },
	{ path: 'ideas/:title', component : WidgetComponent },
	{ path: 'ideas/category/:category', component : WidgetComponent },

	{ path: 'activities/:storename', component : WidgetComponent },
	{ path: 'my/order/details', component : WidgetComponent },
	{ path: 'shop', loadChildren : './shop-page/shop-page.module#ShopPageModule' },

	{ path: 'shop/uniforms',  loadChildren: './landing-page/landing-page.module#LandingPageModule'},

	{ path: 'shop/:gendername', component : WidgetComponent },
	{ path: 'draft/:gendername', component : WidgetComponent },

	{ path: ':product_slug/buy',  loadChildren: './product-page/product-page.module#ProductPageModule'},
	{ path: ':cat1', loadChildren : './shop-page/shop-page.module#ShopPageModule'},
	{ path: ':cat1/:cat2', loadChildren : './shop-page/shop-page.module#ShopPageModule'},
	{ path: ':cat1/:cat2/:cat3', loadChildren : './shop-page/shop-page.module#ShopPageModule'},
	{ path: ':cat1/:cat2/:cat3/:cat4', loadChildren : './shop-page/shop-page.module#ShopPageModule'},
	{ path: ':cat1/:cat2/:cat3/:cat4/:cat5', loadChildren : './shop-page/shop-page.module#ShopPageModule'},
	
	{ path: '**', component : WidgetComponent }	
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {scrollPositionRestoration : 'enabled'})],
  exports: [RouterModule]
})
export class AppRoutingModule { }
