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
    try{
      this.breadcrumbs.forEach(breadcrumb =>{ breadcrumb.url = (new URL(breadcrumb.url)).pathname;})  
    }
    catch(error){
      console.log("breadcrumbs error ==>", error);
    }
    
  	console.log("breadcrumbs ==>", this.breadcrumbs);
  }

}
