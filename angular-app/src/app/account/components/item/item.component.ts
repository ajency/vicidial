import { Component, OnInit, Input, OnChanges } from '@angular/core';

@Component({
  selector: 'app-item',
  templateUrl: './item.component.html',
  styleUrls: ['./item.component.css']
})
export class ItemComponent implements OnInit, OnChanges {

	@Input() item : any;
	@Input() showRefundStatus : any;
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){

  }

}
