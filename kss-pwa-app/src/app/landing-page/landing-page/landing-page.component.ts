import { Component, OnInit, isDevMode } from '@angular/core';
import { ApiServiceService } from '../../service/api-service.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-landing-page',
  templateUrl: './landing-page.component.html',
  styleUrls: ['./landing-page.component.scss']
})
export class LandingPageComponent implements OnInit {

	menuObject : any

  constructor(private apiService: ApiServiceService,
  			private router: Router) { }

  ngOnInit() {
  }

  openLink(link){
    this.router.navigateByUrl(link);
    // this.router.navigateByUrl((new URL(link)).pathname);
  }

}
