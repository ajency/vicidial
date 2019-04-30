import { Component, OnInit, Input, Output, EventEmitter, OnChanges } from '@angular/core';
import { Options } from 'ng5-slider';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: 'app-filter-checkbox',
  templateUrl: './filter-checkbox.component.html',
  styleUrls: ['./filter-checkbox.component.scss']
})
export class FilterCheckboxComponent implements OnInit, OnChanges {

	@Input() filter : any;
	@Input() isMobile : any;
	@Input() selectedFilterCategory : any;
  @Input() collapse : any;

	@Output() filterApplied = new EventEmitter();
	@Output() rangeFilterApplied = new EventEmitter();
  manualRefresh: EventEmitter<void> = new EventEmitter<void>();

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
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  }

  ngOnChanges(){
  	this.sortFilterItems();
  	if(this.filter.attribute_param == 'price'){
        this.options.floor = this.filter.bucket_range.start;
        this.options.ceil = this.filter.bucket_range.end;
        this.options.minLimit = this.filter.bucket_range.start;
        this.options.maxLimit = this.filter.bucket_range.end;
        this.range = this.filter.selected_range;
        this.previous_Range = Object.assign({}, this.filter.selected_range);
  	}
    this.manualRefresh.emit();
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
  	this.filterApplied.emit({filter : filter, value : item.slug, apply : item.is_selected })
  }

  applyPriceRange(filter){
  	console.log("applyPriceRange filter", this.range);
  	if(this.range.start !== null && this.range.end !==null && (this.range.start != this.previous_Range.start || this.range.end != this.previous_Range.end)){
      filter.selected_range = this.range;
  		console.log("applyPriceRange filter", this.range);
  		this.rangeFilterApplied.emit({category : filter.attribute_param, value : this.range})		
  	}
  }

  updateCollapseArray(attribute_param){
    setTimeout(()=>{
      this.collapse.is_collapsed = !this.collapse.is_collapsed
    },100);
    if(attribute_param == 'price')
      this.manualRefresh.emit();
  }

}
