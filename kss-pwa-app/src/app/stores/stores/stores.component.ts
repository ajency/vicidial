import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-stores',
  templateUrl: './stores.component.html',
  styleUrls: ['./stores.component.scss']
})
export class StoresComponent implements OnInit {
	cdnUrl : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  	this.cdnUrl = this.appservice.cdnUrl;
  }

}
