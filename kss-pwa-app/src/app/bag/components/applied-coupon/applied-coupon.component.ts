import { Component, OnInit, Input, OnChanges, SimpleChanges, EventEmitter, Output } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';
@Component({
  selector: 'app-applied-coupon',
  templateUrl: './applied-coupon.component.html',
  styleUrls: ['./applied-coupon.component.css']
})
export class AppliedCouponComponent implements  OnInit, OnChanges {

	@Input() promoApplied : any;
	@Input() promotions : any;
  @Input() orderTotal : any;
  @Input() cartType : any;
  @Input() items : any;

  @Output() editCouponTrigger = new EventEmitter();

	promo : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  }

  ngOnChanges(){
    switch(this.promoApplied.condition.entity){
      case 'cart_price' : 
        this.promoApplied.actual_discount = this.appservice.calculateDiscount(this.promoApplied.action.type, this.promoApplied.action.value, this.orderTotal);        
        break;

      case 'specific_products' :
        this.appservice.productSpecificCouponApplicable(this.promoApplied, this.items);
        break;
    }    
  }

  editCoupon(){
    this.editCouponTrigger.emit(true);
  }

}
