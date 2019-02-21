import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: '[app-gender-box]',
  templateUrl: './gender-box.component.html',
  styleUrls: ['./gender-box.component.scss']
})
export class GenderBoxComponent implements OnInit {
	@Input() tab : any;
  constructor() { }

  ngOnInit() {
  }

}
