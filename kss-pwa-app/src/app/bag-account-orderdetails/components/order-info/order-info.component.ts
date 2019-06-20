import { Component, OnInit, Input, OnChanges } from '@angular/core';

@Component({
  selector: 'app-order-info',
  templateUrl: './order-info.component.html',
  styleUrls: ['./order-info.component.css']
})
export class OrderInfoComponent implements OnInit {

	@Input() order_info : any;
  @Input() showStatus : any;
  @Input() orderSuccess : any;
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	//console.log("order_info ==>", this.order_info)
  }

}
