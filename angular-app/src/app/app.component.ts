import { Component, ViewEncapsulation } from '@angular/core';
import { AppServiceService } from './service/app-service.service';
import { Router } from '@angular/router';
import { ApiServiceService } from './service/api-service.service';
declare var $: any;
declare var openCart: any;

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
  encapsulation: ViewEncapsulation.None
})
export class AppComponent {
  title = 'KSS';
  constructor(private appservice : AppServiceService,
					  	private apiservice : ApiServiceService,
  						private router : Router){

	window.onpopstate = (event)=>{
	  console.log("On popstate location: " + document.location + ", state: " + JSON.stringify(event.state));
	  if(window.location.href.endsWith('#bag')){
	  	this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
	  	this.appservice.closeVerificationModal();
	  	if(!$('#cd-cart').hasClass("speed-in") && (window.location.href.endsWith('#bag') || window.location.href.endsWith('#bag/user-verification') || window.location.href.endsWith('#shipping-address') || window.location.href.endsWith('#shipping-summary')) ){
        console.log("opening cart from angular")
        openCart();
     	}
	  }
	  else if(window.location.href.endsWith('#shipping-address')){
	  	// do nothing
	  	setTimeout(()=>{
	  		this.appservice.directNavigationToShippingAddress = true;
		  	this.router.navigateByUrl('/shipping-details', { skipLocationChange: true });	  		
	  	},50);
	  }
	  else if(window.location.href.endsWith('#bag/user-verification')){
	  	// this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
	  	this.appservice.openVerificationModal();
	  }
	  else if(window.location.href.endsWith('#shipping-summary')){
	  	let url = window.location.href.split("#")[0] + '#bag';
	  	history.replaceState({cart : true}, 'cart', url);
	  }
	  else if(!window.location.href.endsWith('#bag')){
	  	this.appservice.closeCart();
	  }
	}
}

	ngOnInit(){
		if(window.location.href.endsWith('#shipping-address')){
				this.appservice.directNavigationToShippingAddress = true;
				this.router.navigateByUrl('/shipping-details', { skipLocationChange: true });
		}
		else{
			this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
		}
	}
}