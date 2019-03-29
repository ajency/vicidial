import { Component, OnInit, Input, Output, EventEmitter, OnChanges } from '@angular/core';

@Component({
  selector: 'app-quantity-modal',
  templateUrl: './quantity-modal.component.html',
  styleUrls: ['./quantity-modal.component.scss']
})
export class QuantityModalComponent implements OnInit, OnChanges {

	@Output() quantityChanged = new EventEmitter();
	quantity = [1,2,3,4];
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  }

  updateQuantity(quantity){
    console.log("quantity updated ==>",quantity);
    this.quantityChanged.emit(quantity);
  }

}
