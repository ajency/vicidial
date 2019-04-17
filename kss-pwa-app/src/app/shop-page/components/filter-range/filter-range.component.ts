import { Component, OnInit } from '@angular/core';
import { Options } from 'ng5-slider';

@Component({
  selector: 'app-filter-range',
  templateUrl: './filter-range.component.html',
  styleUrls: ['./filter-range.component.scss']
})
export class FilterRangeComponent implements OnInit {

	minValue: number = 0;
	maxValue: number = 7000;
	options: Options = {
		floor: 0,
		ceil: 7000,
		step: 100,
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

}
