import { Component, OnInit, Input, Output, EventEmitter, OnChanges } from '@angular/core';

@Component({
  selector: 'app-filter-checkbox',
  templateUrl: './filter-checkbox.component.html',
  styleUrls: ['./filter-checkbox.component.scss']
})
export class FilterCheckboxComponent implements OnInit, OnChanges {

	@Input() filter : any;
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){

  }

}
