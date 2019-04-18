import { Component, OnInit, Input, Output, EventEmitter, OnChanges } from '@angular/core';
import { Options } from 'ng5-slider';
@Component({
  selector: 'app-filter-checkbox',
  templateUrl: './filter-checkbox.component.html',
  styleUrls: ['./filter-checkbox.component.scss']
})
export class FilterCheckboxComponent implements OnInit, OnChanges {

	@Input() filter : any;
	@Input() isMobile : any;
	@Input() selectedFilterCategory : any;
	minValue: number = 0;
	maxValue: number = 7000;
	options: Options = {
		floor: 0,
		ceil: 7000,
		step: 100,
    hidePointerLabels: true,
		translate: (value: number): string => {
	      return '₹' + value;
	    },
	    combineLabels: (minValue: string, maxValue: string): string => {
	      return 'from ' + minValue + ' up to ' + maxValue;
	    }
	};
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	this.sortFilterItems();
  	if(this.filter.filter_type == 'range_filter'){
  		this.options.floor = this.filter.bucket_range.start;
  		this.options.ceil = this.filter.bucket_range.end;
  		this.minValue = this.filter.selected_range.start;
  		this.maxValue = this.filter.selected_range.end;
  	}
  }

  sortFilterItems(){
  	this.filter.items = this.filter.items.sort((a,b)=>{
  		if(this.filter.sort_order == 'desc')
  			return b[this.filter.sort_on] - a[this.filter.sort_on]
  		return a[this.filter.sort_on] - b[this.filter.sort_on]
  	})
  }

}
