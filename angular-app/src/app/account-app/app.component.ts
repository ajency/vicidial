import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { PlatformLocation } from '@angular/common';
import { AppServiceService } from './services/app-service.service';

@Component({
  selector: 'my-account-app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app';
	constructor(private router : Router,
				private location : PlatformLocation,
				private appservice : AppServiceService){

		if(this.appservice.isLoggedInUser()){
			if(!window.location.href.endsWith('#/account')){
				this.router.navigateByUrl('account/my-orders');
			}
		}
		else{
			this.appservice.redirectUrl = window.location.href;
			this.router.navigateByUrl('account');
		}

		this.location.onPopState((event)=>{
			console.log("location.onPopState triggered");
		  	if(window.location.href.endsWith('#/account')){
			  	this.appservice.closeVerificationModal();			  	
			}

		  	else if(window.location.href.endsWith('#/account/user-verification')){
				this.appservice.openVerificationModal();
		  	}

		  	else if(window.location.href.endsWith('#/account/my-orders')){
		  		// Do nothing -- to be handled later
		  	}

		  	else{		  		
				this.appservice.closeWidget();
				window.location.reload();
		  	}			
		})
	}
}
