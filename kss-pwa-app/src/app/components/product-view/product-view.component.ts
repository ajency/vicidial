import { Component, OnInit, Input, OnChanges } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-product-view',
  templateUrl: './product-view.component.html',
  styleUrls: ['./product-view.component.scss']
})
export class ProductViewComponent implements OnInit, OnChanges {

	@Input() product : any;
  @Input() showLoader : boolean;
  @Input() listPage : any;
  @Input() productPage : any;
  cdnUrl : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
  }

  ngOnChanges(){
    if(!this.listPage && this.product && this.product.url)
      this.product.url = (new URL(this.product.url)).pathname;

    if(this.productPage && this.product && typeof this.product == 'object' ){
      this.product.is_sellable = true;
      this.product.is_available = true;
    }
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  getOffPercentage(list_price, sale_price){
    return this.appservice.calculateOff(list_price, sale_price);
  }

}
