import { Component, OnInit, Input, OnChanges } from '@angular/core';
declare var $: any;

@Component({
  selector: 'app-order',
  templateUrl: './order.component.html',
  styleUrls: ['./order.component.css']
})
export class OrderComponent implements OnInit, OnChanges{

	@Input() sub_orders : any;
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
      this.sub_orders.forEach((sub_order)=>{
        sub_order.items.forEach((item)=>{
          if(item.price_mrp != item.price_final)
            item.off_percentage = Math.round(((item.price_mrp - item.price_final) / (item.price_mrp )) * 100) + '% OFF';
          item.href = '/' + item.product_slug +'/buy?size='+item.size;
          item.images = Array.isArray(item.images) ? ['/img/placeholder.svg', '/img/placeholder.svg', '/img/placeholder.svg'] : Object.values(item.images);
        })
      })
  }
}
