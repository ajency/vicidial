import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../services/api.service';
import { AppService } from '../../services/app.service';
// import menu from '../../../assets/data/menu.json';

@Component({
  selector: 'app-home-page',
  templateUrl: './home-page.component.html',
  styleUrls: ['./home-page.component.scss']
})
export class HomePageComponent implements OnInit {

  homePageElements : any;
	menuObject : any
  constructor(private apiService: ApiService,
              private appService: AppService) { }

  ngOnInit() {
  	console.log("ngOnInit HomePageComponent");
  	// this.menuObject = menu.menu;
    let url = "https://demo8558685.mockable.io/get-menu";
  	this.apiService.request(url,'get',{},{}).then((data)=>{
  		console.log("data ==>", data);
  		this.menuObject = data.menu;
  	})
  	.catch((error)=>{
  		console.log("error in fetching the json",error);
  	})

    url = this.appService.apiUrl + "/api/rest/v1/get-page-element?page_slug=home";
    this.apiService.request(url,'get',{},{}).then((data)=>{
      console.log("home page data ==>", data);
      this.homePageElements = data;
    })
    .catch((error)=>{
      console.log("error in get-home-page-element api ==>", error);
    })

  }

}
