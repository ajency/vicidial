import { Component, OnInit, Input, OnChanges } from '@angular/core';
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
  selectedQuantity : any;
  totalQuantity : any;
  itemIndex : any;

  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){

  }

  ngAfterViewInit(){
    $('[data-toggle="tooltip"]').tooltip();
  }

  updateQuantity(item, index){
    console.log("updateQuantity ==>", item, index);
    this.selectedQuantity = item.quantity;
    this.totalQuantity = 5;
    if(item.available_quantity < 5)
      this.totalQuantity = item.available_quantity;
    this.itemIndex = index;
    $('#qty-modal-cart').modal('show');
    $("#cd-cart").css("overflow-y", "hidden");
    $('.modal-backdrop').appendTo('.angular-app');

    $('#qty-modal-cart').on('hidden.bs.modal', function (e) {
      $("#cd-cart").css("overflow-y", "auto");
    })
   }

}
