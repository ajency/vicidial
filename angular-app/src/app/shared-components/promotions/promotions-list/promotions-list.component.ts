import { Component, OnInit, Input } from '@angular/core';
import { PromotionComponent } from '../promotion/promotion.component';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: 'app-promotions-list',
  templateUrl: './promotions-list.component.html',
  styleUrls: ['./promotions-list.component.css']
})
export class PromotionsListComponent implements OnInit {

	@Input() promotionsList : any;
	@Input() orderTotal : any;

	applicablePromotions : any;
	nonApplicablePromotions : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  	// console.log("ngOnInit", this.promotionsList);
  	this.promotionsList =  this.appservice.sortArray(this.promotionsList);
  	let obj = this.appservice.filterArray(this.promotionsList, this.orderTotal);
  	this.applicablePromotions = obj.applicable;
  	this.nonApplicablePromotions = obj.non_applicable;
  }

}
