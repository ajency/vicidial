import { Component, OnInit, Input, OnChanges } from '@angular/core';

@Component({
  selector: 'app-shipping-address',
  templateUrl: './shipping-address.component.html',
  styleUrls: ['./shipping-address.component.css']
})
export class ShippingAddressComponent implements OnInit, OnChanges {

	@Input() shipping_address : any;
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	// console.log("ngOnChanges ShippingAddressComponent ==>", this.shipping_address);
  }

}
