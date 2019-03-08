import { Component, OnInit, Input, OnChanges } from '@angular/core';

@Component({
  selector: 'app-slider',
  templateUrl: './slider.component.html',
  styleUrls: ['./slider.component.scss']
})
export class SliderComponent implements OnInit, OnChanges {

	@Input() row : any;
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	// console.log("ngOnChanges row ==>", this.row);
  }

}
