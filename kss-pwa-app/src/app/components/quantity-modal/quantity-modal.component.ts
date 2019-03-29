import { Component, OnInit, Input, Output, EventEmitter, OnChanges } from '@angular/core';

@Component({
  selector: 'app-quantity-modal',
  templateUrl: './quantity-modal.component.html',
  styleUrls: ['./quantity-modal.component.scss']
})
export class QuantityModalComponent implements OnInit, OnChanges {

  @Input() totalQuantity : any;
  @Input() selectedQuantity : any;
	@Output() quantityChanged = new EventEmitter();
	quantity : any;
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
    this.quantity = new Array(this.totalQuantity);
    console.log("quantity ==>", this.quantity.length);
  }

  updateQuantity(quantity){
    console.log("quantity updated ==>",quantity);
    this.quantityChanged.emit(quantity);
  }

}
