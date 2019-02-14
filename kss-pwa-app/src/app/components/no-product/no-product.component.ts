import { Component, OnInit, Input, OnChanges } from '@angular/core';

@Component({
  selector: 'app-no-product',
  templateUrl: './no-product.component.html',
  styleUrls: ['./no-product.component.scss']
})
export class NoProductComponent implements OnInit, OnChanges {
	
	@Input() product : any;
  constructor() { }

  ngOnInit() {
  }

   ngOnChanges(){
  	console.log("ngOnChanges no product ==>", this.product);
  }

}
