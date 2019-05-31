import { Component, OnInit, Input, OnChanges, SimpleChanges} from '@angular/core';
import { PromotionComponent } from '../promotion/promotion.component';
import { AppServiceService } from '../../../service/app-service.service';
import * as moment from 'moment';

@Component({
  selector: 'app-promotions-list',
  templateUrl: './promotions-list.component.html',
  styleUrls: ['./promotions-list.component.css']
})
export class PromotionsListComponent implements OnInit, OnChanges {

	@Input() promotionsList : any;
	@Input() orderTotal : any;
  @Input() appliedCoupon : any;
  @Input() items : any;

	applicablePromotions : any;
	nonApplicablePromotions : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  	// console.log("ngOnInit", this.promotionsList, this.orderTotal);
  }

  ngOnChanges() {
    this.updatePromotionsData();
  }

  updatePromotionsData(){
    this.promotionsList = this.promotionsList.filter((promo)=>{ return (promo.condition.filter == 'greater_than') });
    try{
      this.promotionsList.forEach((promo)=>{ 
        promo.actual_discount = this.appservice.calculateDiscount(promo.action.type, promo.action.value, this.orderTotal);
      });
    }
    catch(e){
      console.log("error ==>",e);
    }

    this.applicablePromotions = [];
    this.nonApplicablePromotions = [];
    this.promotionsList.forEach((promo)=>{
      switch(promo.condition.entity){
        case 'cart_price' : 
          if(promo.condition.value[0] <= this.orderTotal)
            this.applicablePromotions.push(promo);
          else
            this.nonApplicablePromotions.push(promo);
          break;

        case 'specific_products' :
          if(this.appservice.productSpecificCouponApplicable(promo, this.items))
            this.applicablePromotions.push(promo);
          else
            this.nonApplicablePromotions.push(promo);
          break;
      }  
    })
  }

  calculateAge(){
  	this.promotionsList.forEach((promotion)=>{
  		promotion.age = this.getAge(promotion.valid_from);
  	})
  }

  getAge(vaild_from){
    let now = moment(moment().format('YYYY-MM-DD HH:mm:ss'));
    let start = moment(vaild_from);
    let duration = moment.duration(now.diff(start));
    return duration.asSeconds();
  }

}
