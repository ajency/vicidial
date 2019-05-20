import { Component, OnInit, Input, OnChanges } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.scss']
})
export class ProductComponent implements OnInit, OnChanges {

	@Input() product : any;
  cdnUrl : any;
  constructor(private appservice : AppServiceService,) { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
  }

  ngOnChanges(){
  	// console.log("ngOnChanges product ==>", this.product);
    this.product.products[0]['product-slug'] = (new URL(this.product.products[0]['product-slug'])).pathname;
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

}
