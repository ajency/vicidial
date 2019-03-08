import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: '[app-happening-month]',
  templateUrl: './happening-month.component.html',
  styleUrls: ['./happening-month.component.scss']
})
export class HappeningMonthComponent implements OnInit {

	@Input() theme : any;
  constructor() { }

  ngOnInit() {
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }
}
