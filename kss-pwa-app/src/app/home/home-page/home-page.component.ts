import { Component, OnInit, isDevMode } from '@angular/core';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';
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
  constructor(private apiService: ApiServiceService,
              private appservice : AppServiceService) {
  }

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
      setTimeout(()=>{
        this.loadCart();
      },2000)      
    })
    .catch((error)=>{
      console.log("error in get-home-page-element api ==>", error);
      this.homePageElements = true;
    })
  }

  loadCart(){
    if(window.location.href.endsWith('#/bag') || window.location.href.endsWith('#/bag/shipping-address') || window.location.href.endsWith('#/bag/shipping-summary'))
        this.appservice.loadCartTrigger();
  }

}
