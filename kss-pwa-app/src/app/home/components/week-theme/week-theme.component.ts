import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: '[app-week-theme]',
  templateUrl: './week-theme.component.html',
  styleUrls: ['./week-theme.component.scss']
})
export class WeekThemeComponent implements OnInit {
	
	@Input() theme : any;
  constructor() { }

  ngOnInit() {
  }

  createDataSrcSet(a,b,c,d,e,f){
    return a+ " " +b +", " +c +" "+d +", " +e +" "+f;
  }
}
