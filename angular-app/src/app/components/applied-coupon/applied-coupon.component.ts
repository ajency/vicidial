import { Component, OnInit, Input, OnChanges, SimpleChanges, EventEmitter, Output } from '@angular/core';
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

  @Output() editCouponTrigger = new EventEmitter();

	promo : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  }

  ngOnChanges(){
    this.promoApplied.actual_discount = this.appservice.calculateDiscount(this.promoApplied.action.type, this.promoApplied.action.value, this.orderTotal);
    this.promo = this.promoApplied;
  }

  editCoupon(){
    this.editCouponTrigger.emit(true);
  }

}
