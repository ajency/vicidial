import { Component, ViewEncapsulation, Output, EventEmitter} from '@angular/core';
import { AppServiceService } from './service/app-service.service';
import { Router } from '@angular/router';
import { ApiServiceService } from './service/api-service.service';
import { PlatformLocation } from '@angular/common';

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
  						private router : Router,
              private loc : PlatformLocation){

		this.loc.onPopState(()=>{
			// console.log("On popstate location: ", document.location);
			if(window.location.href.endsWith('#/') || window.location.href.endsWith('#') || (!window.location.href.includes("#")) ){
			  	this.appservice.closeCart();
			  }
		});
	}

	ngOnInit(){
		console.log("ngOnInit AppComponent");
	}
}