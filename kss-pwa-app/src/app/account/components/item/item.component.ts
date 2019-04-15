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
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){

  }

  ngAfterViewInit(){
    $('[data-toggle="tooltip"]').tooltip();
  }

}
