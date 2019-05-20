import { Component, OnInit, Input, OnChanges, AfterViewInit } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: 'app-trending',
  templateUrl: './trending.component.html',
  styleUrls: ['./trending.component.scss']
})
export class TrendingComponent implements OnInit, OnChanges, AfterViewInit {

	@Input() trending : any;
	trendingGroup = [];
  cdnUrl : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
  }

  ngOnChanges(){
  	// console.log("trending ==>", this.trending);
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

  ngAfterViewInit(){
    console.log("ngAfterViewInit stories component");
  }

}
