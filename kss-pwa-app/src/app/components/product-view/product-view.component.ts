import { Component, OnInit, Input, OnChanges } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-product-view',
  templateUrl: './product-view.component.html',
  styleUrls: ['./product-view.component.scss']
})
export class ProductViewComponent implements OnInit, OnChanges {

	@Input() product : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  }

  ngOnChanges(){

  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  getOffPercentage(list_price, sale_price){
    return this.appservice.calculateOff(list_price, sale_price);
  }

}
