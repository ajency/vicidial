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
		this.router.navigateByUrl('/my-orders');

		this.location.onPopState((event)=>{
			console.log("location.onPopState triggered");
			this.appservice.closeWidget();
		})
	}
}
