import { Component, OnInit, isDevMode } from '@angular/core';
import { ApiServiceService } from '../../service/api-service.service';

@Component({
  selector: 'app-landing-page',
  templateUrl: './landing-page.component.html',
  styleUrls: ['./landing-page.component.scss']
})
export class LandingPageComponent implements OnInit {

	menuObject : any

  constructor(private apiService: ApiServiceService) { }

  ngOnInit() {
  }

}
