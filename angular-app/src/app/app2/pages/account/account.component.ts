import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../services/app-service.service';

@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.css']
})
export class AccountComponent implements OnInit {

  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  	this.appservice.removeLoader();
  }

}
