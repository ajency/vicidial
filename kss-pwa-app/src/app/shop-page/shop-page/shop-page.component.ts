import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-shop-page',
  templateUrl: './shop-page.component.html',
  styleUrls: ['./shop-page.component.scss']
})
export class ShopPageComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  }

  status: boolean = false;
  mobilefilter: boolean = false;

  clickEvent(){
    this.status = !this.status;       
  }

  showMobileFilter(){
    this.mobilefilter = !this.mobilefilter;       
  }

}
