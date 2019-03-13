import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-gender-category',
  templateUrl: './gender-category.component.html',
  styleUrls: ['./gender-category.component.scss']
})
export class GenderCategoryComponent implements OnInit {

	@Input() tabs : any;
	isDraftPage : boolean = false;
  constructor() { }

  ngOnInit() {
  	if(window.location.pathname == '/drafthome')
      this.isDraftPage = true;
  }

  ngOnChanges(){

  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

}
