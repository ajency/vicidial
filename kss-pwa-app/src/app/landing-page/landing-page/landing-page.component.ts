import { Component, OnInit, isDevMode } from '@angular/core';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-landing-page',
  templateUrl: './landing-page.component.html',
  styleUrls: ['./landing-page.component.scss']
})
export class LandingPageComponent implements OnInit {

	menuObject : any
  cdnUrl : any;
  constructor(private apiService: ApiServiceService,
        private appservice : AppServiceService,
  			private router: Router) { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
  }

  openLink(link){
    this.router.navigateByUrl(link);
    // this.router.navigateByUrl((new URL(link)).pathname);
  }

}
