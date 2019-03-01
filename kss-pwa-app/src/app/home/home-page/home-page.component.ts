import { Component, OnInit, isDevMode } from '@angular/core';
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
  storiesLoaded : boolean = false;
  showTrendingSection : boolean = false;
  showStories : boolean = false;
  constructor(private apiService: ApiService,
              private appService: AppService) { }

  ngOnInit() {
  	console.log("ngOnInit HomePageComponent");
  	// this.menuObject = menu.menu;
    // let url = "https://demo8558685.mockable.io/get-menu";
    let url = isDevMode() ? "https://demo8558685.mockable.io/get-menu" : "/api/rest/v1/test/get-menu"
  	this.apiService.request(url,'get',{},{}).then((data)=>{
  		console.log("data ==>", data);
  		this.menuObject = data.menu;
  	})
  	.catch((error)=>{
  		console.log("error in fetching the json",error);
  	})

    url = isDevMode() ? "https://demo8558685.mockable.io/get-home-page-elements-test" : "/api/rest/v1/test/get-page-element-dummy?page_slug=home";
    // url = "https://demo8558685.mockable.io/get-home-page-elements-test";
    this.apiService.request(url,'get',{},{}).then((data)=>{
      console.log("home page data ==>", data);
      this.homePageElements = data;
    })
    .catch((error)=>{
      console.log("error in get-home-page-element api ==>", error);
      this.homePageElements = true;
    })
  }

}
