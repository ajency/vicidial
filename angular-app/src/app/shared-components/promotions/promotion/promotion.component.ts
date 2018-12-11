import { Component, OnInit, Input } from '@angular/core';
import * as moment from 'moment';

@Component({
  selector: 'app-promotion',
  templateUrl: './promotion.component.html',
  styleUrls: ['./promotion.component.css']
})
export class PromotionComponent implements OnInit {

	@Input() coupon : any;
	@Input() orderTotal : any;
  constructor() { }

  ngOnInit() {
  	// console.log("ngOnInit promotion component ==>", this.coupon);
  }

  calculateOff(value, type){
  	return ( type == 'cart_fixed' ? value : (this.orderTotal * value / 100) )
  }

  getValidTill(valid_till){
  	return moment(valid_till, "YYYY-MM-DD HH:mm:ss").format("DD MMM, YYYY");
  }

}
