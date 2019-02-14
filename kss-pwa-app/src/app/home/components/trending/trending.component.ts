import { Component, OnInit, Input, OnChanges } from '@angular/core';

@Component({
  selector: 'app-trending',
  templateUrl: './trending.component.html',
  styleUrls: ['./trending.component.scss']
})
export class TrendingComponent implements OnInit, OnChanges {

	@Input() trending : any;
	trendingGroup = [];
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	console.log("trending ==>", this.trending);
  	this.chunkArray(this.trending, 4);
  }

  chunkArray(array, chunkSize){
  	this.trendingGroup = [];
  	for(let index = 0; index<array.length; index+=chunkSize){
  		let chunk = array.slice(index,index+chunkSize);
  		this.trendingGroup.push(chunk);
  	}
  	console.log(this.trendingGroup);
  }

}
