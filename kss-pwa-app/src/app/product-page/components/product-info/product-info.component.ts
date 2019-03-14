import { Component, OnInit, Input, OnChanges } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';
@Component({
  selector: 'app-product-info',
  templateUrl: './product-info.component.html',
  styleUrls: ['./product-info.component.scss']
})
export class ProductInfoComponent implements OnInit, OnChanges {

	@Input() attributes : any;
	@Input() facets : any;
	@Input() variants : any;

  selectedSize : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {

  }

  ngOnChanges(){
  	this.variants = this.variants.sort((a,b)=>{ return a.variant_facets.variant_size.sequence - b.variant_facets.variant_size.sequence});
  	console.log("attributes =>", this.attributes, this.facets);
  }

  getOffPercentage(list_price, sale_price){
  	return this.appservice.calculateOff(list_price, sale_price);
  }

  updatePrice(){
    console.log("inside updatePriceprice", this.selectedSize)
  }

}
