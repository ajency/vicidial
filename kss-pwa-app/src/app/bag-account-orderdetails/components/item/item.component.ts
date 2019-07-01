import { Component, OnInit, Input, OnChanges, EventEmitter, Output } from '@angular/core';
declare var $: any;

@Component({
  selector: 'app-item',
  templateUrl: './item.component.html',
  styleUrls: ['./item.component.scss']
})
export class ItemComponent implements OnInit, OnChanges {

	@Input() item : any;
  @Input() showStatus : any;
  @Input() showReturnbtn : any;
  @Input() returnItem : any;
  @Output() openQuantityModalTrigger = new EventEmitter()
  selectedQuantity : any;
  totalQuantity : any;

  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){

  }

  ngAfterViewInit(){
    try{
      $('[data-toggle="tooltip"]').tooltip();
    }
    catch(error){
      console.log("jqury not found")
    }
  }

  openQuantityModal(){
    if(this.returnItem)
      this.openQuantityModalTrigger.emit(this.item);
   }

}
