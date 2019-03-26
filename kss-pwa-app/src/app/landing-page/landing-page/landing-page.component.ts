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

	  let url = isDevMode() ? "https://demo8558685.mockable.io/get-menu" : "/api/rest/v1/test/get-menu"
		this.apiService.request(url,'get',{},{}).then((data)=>{
			console.log("data ==>", data);
			this.menuObject = data.menu;
		})
		.catch((error)=>{
			console.log("error in fetching the json",error);
		})
  }

}
