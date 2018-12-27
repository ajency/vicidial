import { Component, ViewEncapsulation, Output, EventEmitter} from '@angular/core';
import { AppServiceService } from './service/app-service.service';
import { Router } from '@angular/router';
import { ApiServiceService } from './service/api-service.service';
declare var $: any;
declare var openCart: any;

@Component({
  selector: 'cart-app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
  encapsulation: ViewEncapsulation.None
})
export class AppComponent {
  title = 'KSS';

  @Output() loginSuccessForBag : EventEmitter<any> = new EventEmitter();

  constructor(private appservice : AppServiceService,
					  	private apiservice : ApiServiceService,
  						private router : Router){

  	this.appservice.loginComplete.subscribe((data)=> {
      console.log("loginSuccess event fired");
      // this.appservice.loginSuccessComplete();
      this.loginSuccessForBag.emit();
    })

	window.onpopstate = (event)=>{
	  console.log("On popstate location: " + document.location + ", state: " + JSON.stringify(event.state));
	  // if(window.location.href.endsWith('#bag')){
	  // 	this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
	  // 	this.appservice.closeVerificationModal();
	  // 	if(!$('#cd-cart').hasClass("speed-in") && (window.location.href.endsWith('#bag') || window.location.href.endsWith('#bag/user-verification') || window.location.href.endsWith('#shipping-address') || window.location.href.endsWith('#shipping-summary')) ){
   //      console.log("opening cart from angular")
   //      openCart();
   //   	}
	  // }
	  // else if(window.location.href.endsWith('#shipping-address')){
	  // 	// do nothing
	  // 	setTimeout(()=>{
	  // 		this.appservice.directNavigationToShippingAddress = true;
		 //  	this.router.navigateByUrl('/shipping-details', { skipLocationChange: true });	  		
	  // 	},50);
	  // }
	  // else if(window.location.href.endsWith('#bag/user-verification')){
	  // 	this.appservice.openVerificationModal();
	  // }
	  // else if(window.location.href.endsWith('#shipping-summary')){
	  // 	let url = window.location.href.split("#")[0] + '#bag';
	  // 	history.replaceState({cart : true}, 'cart', url);
	  // }
	 if(window.location.href.endsWith('#/') || window.location.href.endsWith('#') || (!window.location.href.includes("#")) ){
	  	this.appservice.closeCart();
	  	// window.location.reload();
	  }
	}
}

	ngOnInit(){

	}
}