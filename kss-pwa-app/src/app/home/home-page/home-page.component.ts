import { Component, OnInit, isDevMode } from '@angular/core';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';

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
  cdnUrl : any;
  constructor(private apiService: ApiServiceService,
              private appservice : AppServiceService) {
  }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
    let url =  "/api/rest/v2/get-page-elements?page_slug=home";
    if(window.location.pathname == '/')
      url = url + '&published=true';
    if(isDevMode())
      url = "https://demo8558685.mockable.io/get-home-page-elements-test";
    this.apiService.request(url,'get',{},{}).then((data)=>{
      this.showLoader = false;
      this.homePageElements = data;     
    })
    .catch((error)=>{
      this.showLoader = false;
    })
  }

}
