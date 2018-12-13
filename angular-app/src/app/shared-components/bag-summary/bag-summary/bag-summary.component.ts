import { Component, OnInit, Input, OnChanges, SimpleChanges } from '@angular/core';

@Component({
  selector: 'app-bag-summary',
  templateUrl: './bag-summary.component.html',
  styleUrls: ['./bag-summary.component.css']
})
export class BagSummaryComponent implements  OnInit, OnChanges {
	
	@Input() summary : any;
  
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	 console.log("ngOnChanges bag-summary component ==>", this.summary);
  }

}
