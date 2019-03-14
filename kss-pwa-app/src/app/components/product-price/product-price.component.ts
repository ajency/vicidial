import { Component, OnInit, Input, OnChanges } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';
@Component({
  selector: 'app-product-price',
  templateUrl: './product-price.component.html',
  styleUrls: ['./product-price.component.scss']
})
export class ProductPriceComponent implements OnInit, OnChanges {

	@Input() variants : any;
  @Input() selectedVariantId : any;
	selectedVariant : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  }

  ngOnChanges(){
  	console.log("variants ==>",this.variants)
    if(this.selectedVariantId)
      this.selectedVariant = this.variants.find((variant)=>{ return variant.variant_attributes.variant_id === this.selectedVariantId});
    else
    	this.selectedVariant = this.variants.find((variant)=>{ return variant.is_default === true});
  	console.log("default variant ==>", this.selectedVariant);
  }

  getOffPercentage(list_price, sale_price){
  	return this.appservice.calculateOff(list_price, sale_price);
  }

}
