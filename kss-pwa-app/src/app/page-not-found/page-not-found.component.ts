import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../service/app-service.service';

@Component({
  selector: 'app-page-not-found',
  templateUrl: './page-not-found.component.html',
  styleUrls: ['./page-not-found.component.scss']
})
export class PageNotFoundComponent implements OnInit {

  constructor(private appservice : AppServiceService,) { }

  ngOnInit() {
  	console.log("ngOnInit page-not-found component");
  }

  ngAfterViewInit(){
  	console.log("ngAfterViewInit page-not-found component");
  	setTimeout(()=>{
		if(window.location.href.includes('#/bag') || window.location.href.includes('#/account'))
	        this.appservice.loadCartTrigger();
  	},500)  	
  }

}
