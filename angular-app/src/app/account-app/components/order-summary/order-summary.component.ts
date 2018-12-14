import { Component, OnInit, Input, OnChanges } from '@angular/core';
import { BagSummaryComponent } from '../../../shared-components/bag-summary/bag-summary/bag-summary.component';
@Component({
  selector: 'app-order-summary',
  templateUrl: './order-summary.component.html',
  styleUrls: ['./order-summary.component.css']
})
export class OrderSummaryComponent implements OnInit, OnChanges {

	@Input() order_summary : any;

  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	console.log("ngOnChanges OrderSummaryComponent ===>", this.order_summary);
  }

}
