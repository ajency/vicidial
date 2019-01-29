import { Component, OnInit, Input, OnChanges, SimpleChanges} from '@angular/core';
import { PromotionComponent } from '../promotion/promotion.component';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: 'app-promotions-list',
  templateUrl: './promotions-list.component.html',
  styleUrls: ['./promotions-list.component.css']
})
export class PromotionsListComponent implements OnInit, OnChanges {

	@Input() promotionsList : any;
	@Input() orderTotal : any;

	applicablePromotions : any;
	nonApplicablePromotions : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  	// console.log("ngOnInit", this.promotionsList, this.orderTotal);
	  	this.updatePromotionsData();
  }

  ngOnChanges(changes: SimpleChanges) {
    // console.log("ngOnChanges", this.promotionsList, this.orderTotal);
    this.updatePromotionsData();
    this.orderTotal = 1000;
  }

  updatePromotionsData(){
    this.promotionsList = this.promotionsList.filter((promo)=>{ return (promo.condition.entity == 'cart_price' && promo.condition.filter == 'greater_than') });

    try{
      this.promotionsList.forEach((promo)=>{ 
        promo.actual_discount = this.appservice.calculateDiscount(promo.action.type, promo.action.value, this.orderTotal);
        console.log(promo.actual_discount);
      });
    }
    catch(e){
      console.log("error ==>",e);
    }
  	this.promotionsList =  this.appservice.sortArray(this.promotionsList);
  	console.log(this.promotionsList);
		// this.calculateAge();
  	let obj = this.appservice.filterArray(this.promotionsList, this.orderTotal);
  	this.applicablePromotions = obj.applicable;
  	this.nonApplicablePromotions = obj.non_applicable;
    console.log("filtered array ==>", obj);
  }

  calculateAge(){
  	this.promotionsList.forEach((promotion)=>{
  		promotion.age = this.appservice.getAge(promotion.valid_from);
  		// console.log(promotion.age);
  	})
  }

}
