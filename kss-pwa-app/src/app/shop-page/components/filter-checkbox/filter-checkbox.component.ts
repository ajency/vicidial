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

	@Output() filterApplied = new EventEmitter();
	@Output() rangeFilterApplied = new EventEmitter();

	minValue: number = 0;
	maxValue: number = 7000;
	range : any = {}
	previous_Range : any = {};
	options: Options = {
		floor: 0,
		ceil: 7000,
		step: 100,
    hidePointerLabels: true,
    minLimit: 0,
    maxLimit: 7000,
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
  		this.options.minLimit = this.filter.bucket_range.start;
  		this.options.maxLimit = this.filter.bucket_range.end;
  		this.range = this.filter.selected_range;
  		this.previous_Range = Object.assign({}, this.filter.selected_range);
  		// this.minValue = this.filter.selected_range.start;
  		// this.maxValue = this.filter.selected_range.end;
  	}
  }

  sortFilterItems(){
  	this.filter.items = this.filter.items.sort((a,b)=>{
  		if(this.filter.sort_order == 'desc')
  			return b[this.filter.sort_on] - a[this.filter.sort_on]
  		return a[this.filter.sort_on] - b[this.filter.sort_on]
  	})
  }

  applyFilter(filter, item){
  	// console.log("applyFilter ==>",filter, item)
  	this.filterApplied.emit({category : filter.header.facet_name, value : item.facet_value, apply : item.is_selected })
  }

  applyPriceRange(filter){
  	// console.log("applyPriceRange filter", this.range);
  	if(this.range.start != this.previous_Range.start || this.range.end != this.previous_Range.end){
  		console.log("applyPriceRange filter", this.range);
  		this.rangeFilterApplied.emit({category : filter.header.facet_name, value : this.range})		
  	}
  }

}
