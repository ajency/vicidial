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
  	console.log("ngOnInit HomePageComponent", window.location.pathname);
    let url =  "/api/rest/v1/test/get-page-element-dummy?page_slug=home";
    if(window.location.pathname == '/')
      url = url + '&published=true';
    if(isDevMode())
      url = "https://demo8558685.mockable.io/get-home-page-elements-test";
    this.apiService.request(url,'get',{},{}).then((data)=>{
      console.log("home page data ==>", data);
      this.showLoader = false;
      this.homePageElements = data;     
    })
    .catch((error)=>{
      console.log("error in get-home-page-element api ==>", error);
      this.showLoader = false;
      // this.homePageElements = true;
    })
  }

}
