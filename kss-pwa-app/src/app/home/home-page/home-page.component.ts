import { Component, OnInit, isDevMode } from '@angular/core';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';
// import menu from '../../../assets/data/menu.json';

declare var published_home: any;

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
  showLoader : boolean = true;
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

    console.log("published_home ==>", published_home);
    if(published_home)
      url = url + '&published=true';
    this.apiService.request(url,'get',{},{}).then((data)=>{
      console.log("home page data ==>", data);
      this.showLoader = false;
      this.homePageElements = data;
      // setTimeout(()=>{
        this.loadCart();
      // },1000)      
    })
    .catch((error)=>{
      console.log("error in get-home-page-element api ==>", error);
      this.showLoader = false;
      // this.homePageElements = true;
    })
  }

  loadCart(){
    if(window.location.href.endsWith('#/bag') || window.location.href.endsWith('#/bag/shipping-address') || window.location.href.endsWith('#/bag/shipping-summary')){
      this.appservice.loadCartFromAngular = true;
      // let url = window.location.href.split("#")[0] + '#/bag';
      // history.pushState({bag : true}, 'bag', url);
      // console.log("openCart");
      this.appservice.loadCartTrigger();
    }
    else if(window.location.href.endsWith('#/account') || window.location.href.endsWith('#/account/my-orders') || window.location.href.includes('#/account/my-orders/')){
      this.appservice.loadAccountFromAngular = true;
      // let url = window.location.href.split("#")[0] + '#/account';
      // history.pushState({bag : true}, 'account', url);
      // console.log("openAccount");
      this.appservice.loadCartTrigger();
    }        
  }

}
