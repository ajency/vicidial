import { Component, OnInit, Input, OnChanges, Output, EventEmitter } from '@angular/core';

declare var $: any;

@Component({
  selector: 'app-order',
  templateUrl: './order.component.html',
  styleUrls: ['./order.component.scss']
})
export class OrderComponent implements OnInit, OnChanges{

  @Output() returnItemTrigger = new EventEmitter();
	@Input() items : any;
  @Input() showStatus : any;

  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	this.formatOrdersData();
  }

  ngAfterViewInit(){
    $('[data-toggle="tooltip"]').tooltip();
  }

  formatOrdersData(){
    this.items.forEach((item)=>{
      if(item.price_mrp != item.price_final)
        item.off_percentage = Math.round(((item.price_mrp - item.price_final) / (item.price_mrp )) * 100) + '% OFF';
      item.href = '/' + item.product_slug +'/buy?size='+item.size;
      item.images = Array.isArray(item.images) ? ['/img/placeholder.svg', '/img/placeholder.svg', '/img/placeholder.svg'] : Object.values(item.images);
    })
  }

  returnItem(item){
    console.log("return item ==>",  item);
    this.returnItemTrigger.emit(item);
  }
}
