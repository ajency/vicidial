import { Component, OnInit } from '@angular/core';
import { ApiService } from './services/api.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'kss-pwa-app';
  time : any;

  constructor(private apiService: ApiService) { 

  }

  ngOnInit(){
  	// console.log("ngOnInit AppComponent");
  	// let url = 'http://worldclockapi.com/api/json/utc/now';
  	// this.apiService.request(url,'get',{},{}).then((response)=>{
  	// 	console.log("response ==>", response);
  	// 	this.time = new Date(response.currentDateTime)
  	// })
  	// .catch((error)=>{
  	// 	console.log("error ==>", error);
  	// })

  	// url = "/rest/v1/anonymous/states/all";
  	// this.apiService.request(url,'get',{},{}).then((response)=>{
  	// 	console.log("response from state api ==>", response);  		
  	// })
  	// .catch((error)=>{
  	// 	console.log("error ==>", error);
  	// })
  }

  goToHomePage(){
		if(!navigator.onLine){
			console.log("You are offline");
			alert("You are offline");
		}
		else{
			window.location.href = "/shop";
		}
	}
}

