import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-no-connection',
  templateUrl: './no-connection.component.html',
  styleUrls: ['./no-connection.component.scss']
})
export class NoConnectionComponent implements OnInit {
	cdnUrl : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  	this.cdnUrl = this.appservice.cdnUrl;
  }

}
