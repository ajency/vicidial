import { Component, OnInit, Input, OnChanges, Output, EventEmitter } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';
import * as moment from 'moment';
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

  constructor(private appservice : AppServiceService) { }

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
      if(Array.isArray(item.images)){
        item.images = {};
        item['1x'] = '/img/placeholder.svg';
        item['2x'] = '/img/placeholder.svg';
        item['3x'] = '/img/placeholder.svg';
      }
    })
  }

  returnItem(item){
    console.log("return item ==>",  item);
    this.returnItemTrigger.emit(item);
  }

  isReturnPolicyValid(date){
    if(this.getAge(date) < 0)
      return true
    return false;
  }

  getValidTill(date){
    return moment(date, "YYYY-MM-DD HH:mm:ss").format("DD MMM, YYYY");
  }

  getAge(vaild_from){
    let now = moment(moment().format('YYYY-MM-DD HH:mm:ss'));
    let start = moment(vaild_from);
    let duration = moment.duration(now.diff(start));
    return duration.asSeconds();
  }
}
