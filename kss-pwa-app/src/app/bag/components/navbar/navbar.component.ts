import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent implements OnInit {
	@Output() closeCartTrigger = new EventEmitter();
  cdnUrl : any;
  constructor() { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
  }

  closeCart(){
  	this.closeCartTrigger.emit();
  }

}
