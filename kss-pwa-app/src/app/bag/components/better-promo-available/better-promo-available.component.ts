import { Component,  OnInit, Input, OnChanges, SimpleChanges} from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: 'app-better-promo-available',
  templateUrl: './better-promo-available.component.html',
  styleUrls: ['./better-promo-available.component.css']
})
export class BetterPromoAvailableComponent implements OnInit, OnChanges {
	@Input() promoApplied : any;
	@Input() promotions : any;
	@Input() orderTotal : any;

	promo : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  }

  ngOnChanges(){
  	console.log("ngOnChanges better-promo-available component ==>", this.promoApplied, this.promotions);
  	let filterd_obj = this.appservice.filterArray(this.promotions, this.orderTotal);
  	let applicable = filterd_obj.applicable;
  	console.log(applicable);
  	if(applicable.length){
  		let sorted_array = this.appservice.sortByDiscount(applicable);
  		// sorted_array.reverse();
	  	console.log("sorted_array ==>", sorted_array);
	  	let applied_promo = this.promotions.find((promotion)=>{ return this.promoApplied == promotion.promotion_id});
	  	if(applied_promo && (applied_promo.actual_discount < sorted_array[0].actual_discount)){
	  		this.promo = sorted_array[0];
	  	}
  	}  	
  }

}
