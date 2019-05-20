import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-page-not-found',
  templateUrl: './page-not-found.component.html',
  styleUrls: ['./page-not-found.component.scss']
})
export class PageNotFoundComponent implements OnInit {
	cdnUrl : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  	this.cdnUrl = this.appservice.cdnUrl;
  }

}
