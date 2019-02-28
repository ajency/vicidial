import { Component, OnInit, Input, OnChanges } from '@angular/core';

@Component({
  selector: 'app-payment-info',
  templateUrl: './payment-info.component.html',
  styleUrls: ['./payment-info.component.css']
})
export class PaymentInfoComponent implements OnInit, OnChanges {

	@Input() payment_info : any;
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	// console.log("ngOnChanges payment-info component ==>", this.payment_info);
  }

  getSubstr(string){
  	// console.log("string ==>", string);
    if(string)
    	return string.substring(12,16);
  }

}
