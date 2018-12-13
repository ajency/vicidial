import { Component, OnInit, Input, OnChanges, SimpleChanges } from '@angular/core';

@Component({
  selector: 'app-applied-coupon',
  templateUrl: './applied-coupon.component.html',
  styleUrls: ['./applied-coupon.component.css']
})
export class AppliedCouponComponent implements  OnInit, OnChanges {

	@Input() promoApplied : any;
	@Input() promotions : any;

	promo : any;
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	// console.log("ngOnChanges applied-coupon component ==>", this.promoApplied, this.promotions);
  	this.promo = this.promotions.find((promotion)=>{ return this.promoApplied == promotion.promotion_id});
  }

}
