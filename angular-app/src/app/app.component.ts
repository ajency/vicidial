import { Component, ViewEncapsulation } from '@angular/core';
import { AppServiceService } from './service/app-service.service';
import { Router } from '@angular/router';
import { ApiServiceService } from './service/api-service.service';

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
	  console.log("location: " + document.location + ", state: " + JSON.stringify(event.state));
	  if(window.location.href.endsWith('#cart')){
	  	this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
	  	this.appservice.closeVerificationModal();
	  }
	  else if(window.location.href.endsWith('#shipping-address')){
	  	console.log("do nothing");
	  	// do nothing
	  }
	  else if(!window.location.href.endsWith('#cart')){
	  	console.log("close cart");
	  	this.appservice.cartClosedFromShippingPages = true;
	  	this.appservice.closeCart();
	  }
	}
}

	ngOnInit(){
		if(window.location.href.endsWith('#shipping-address')){
				console.log("#shipping-address");
				this.appservice.directNavigationToShippingAddress = true;
				this.router.navigateByUrl('/shipping-details', { skipLocationChange: true });
		}
		else{
			console.log("naviagting to cart page")
			this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
		}
	}
}