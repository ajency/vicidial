import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../service/app-service.service';

@Component({
  selector: 'app-widget',
  templateUrl: './widget.component.html',
  styleUrls: ['./widget.component.scss']
})
export class WidgetComponent implements OnInit {

  constructor(private appservice : AppServiceService,) { }

  ngOnInit() {
  	console.log("ngOnInit widget component");
  }

  ngAfterViewInit(){
  	console.log("ngAfterViewInit widget component");
  	setTimeout(()=>{
		if(window.location.href.includes('#/bag') || window.location.href.includes('#/account'))
	        this.appservice.loadCartTrigger();
  	},500)  	
  }

}
