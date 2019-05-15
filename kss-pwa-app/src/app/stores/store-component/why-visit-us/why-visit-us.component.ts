import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: 'app-why-visit-us',
  templateUrl: './why-visit-us.component.html',
  styleUrls: ['./why-visit-us.component.scss']
})
export class WhyVisitUsComponent implements OnInit {
	cdnUrl : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  	this.cdnUrl = this.appservice.cdnUrl;
  }

}
