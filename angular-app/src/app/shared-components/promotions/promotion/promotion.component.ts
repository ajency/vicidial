import { Component, OnInit, Input } from '@angular/core';

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
  	return ( type == 'value' ? value : (this.orderTotal * value / 100) )
  }

}
