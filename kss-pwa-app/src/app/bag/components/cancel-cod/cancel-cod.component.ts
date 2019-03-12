import { Component, OnInit, Output, EventEmitter } from '@angular/core';
declare var $: any;
@Component({
  selector: 'app-cancel-cod',
  templateUrl: './cancel-cod.component.html',
  styleUrls: ['./cancel-cod.component.scss']
})
export class CancelCodComponent implements OnInit {

	@Output() cancelCODTriggered = new EventEmitter();
  constructor() { }

  ngOnInit() {
  }

  cancelCOD(){
  	this.hideModal();
  	this.cancelCODTriggered.emit();
  }

  hideModal(){
    $('#cancel-cod').modal('hide');
    $("#cd-cart,.kss_shipping_summary").css("overflow", "auto");
    $('.modal-backdrop').remove();
  }

}
