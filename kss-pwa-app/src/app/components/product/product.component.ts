import { Component, OnInit, Input, OnChanges } from '@angular/core';

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.scss']
})
export class ProductComponent implements OnInit, OnChanges {

	@Input() product : any;
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	// console.log("ngOnChanges product ==>", this.product);
  }

}
