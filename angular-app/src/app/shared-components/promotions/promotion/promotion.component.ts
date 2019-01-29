import { Component, OnInit, Input } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';
import * as moment from 'moment';

@Component({
  selector: 'app-promotion',
  templateUrl: './promotion.component.html',
  styleUrls: ['./promotion.component.css']
})
export class PromotionComponent implements OnInit {

	@Input() coupon : any;
	@Input() orderTotal : any;

  selectedCoupon : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  	// console.log("ngOnInit promotion component ==>", this.coupon);
  }

  getValidTill(valid_till){
  	return moment(valid_till, "YYYY-MM-DD HH:mm:ss").format("DD MMM, YYYY");
  }

  couponChanged(){
    console.log("coupon ==>", this.selectedCoupon);
  }

}
