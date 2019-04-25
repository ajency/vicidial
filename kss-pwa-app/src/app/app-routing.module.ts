import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { WidgetComponent } from './widget/widget.component';
import { RouteGuardService as RouteGuard } from './services/route-guard.service';

const routes: Routes = [
	{ path: '',  loadChildren: './home/home.module#HomeModule'},
	{ path: 'drafthome',  loadChildren: './home/home.module#HomeModule'},
	{ path: ':product_slug/buy',  loadChildren: './product-page/product-page.module#ProductPageModule'},
	{ path: 'shop/uniforms',  loadChildren: './landing-page/landing-page.module#LandingPageModule'},
	{ path: 'about-us',  loadChildren: './about-us/about-us.module#AboutUsModule'},
	{ path: 'privacy-policy',  loadChildren: './privacy-policy/privacy-policy.module#PrivacyPolicyModule'},
	{ path: 'terms-and-conditions',  loadChildren: './terms-and-conditions/terms-and-conditions.module#TermsAndConditionsModule'},
	{ path: 'faq',  loadChildren: './faq/faq.module#FaqModule'},
	{ path: 'contact',  loadChildren: './contact-us/contact-us.module#ContactUsModule'},
	{ path: 'stores',  loadChildren: './stores/stores.module#StoresModule'},
	{ path: '**', component : WidgetComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {scrollPositionRestoration : 'top'})],
  exports: [RouterModule]
})
export class AppRoutingModule { }
