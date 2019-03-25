import { Component, OnInit, Input, OnChanges } from '@angular/core';

@Component({
  selector: 'app-breadcrums',
  templateUrl: './breadcrums.component.html',
  styleUrls: ['./breadcrums.component.scss']
})
export class BreadcrumsComponent implements OnInit, OnChanges {

	@Input() breadcrumbs : any;
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	this.breadcrumbs = this.breadcrumbs.sort((a,b)=>{ return a.position - b.position});
  	console.log("breadcrumbs ==>", this.breadcrumbs);
  }

}
