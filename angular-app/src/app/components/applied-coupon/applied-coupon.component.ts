import { Component, OnInit, Input, OnChanges, SimpleChanges } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';
@Component({
  selector: 'app-applied-coupon',
  templateUrl: './applied-coupon.component.html',
  styleUrls: ['./applied-coupon.component.css']
})
export class AppliedCouponComponent implements  OnInit, OnChanges {

	@Input() promoApplied : any;
	@Input() promotions : any;
  @Input() orderTotal : any;

	promo : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  }

  ngOnChanges(){
  	// console.log("ngOnChanges applied-coupon component ==>", this.promoApplied, this.promotions);
  	// this.promo = this.promotions.find((promotion)=>{ return this.promoApplied == promotion.promotion_id});
    this.promoApplied.actual_discount = this.appservice.calculateDiscount(this.promoApplied.action.type, this.promoApplied.action.value, this.orderTotal);
    this.promo = this.promoApplied;
  }

}
