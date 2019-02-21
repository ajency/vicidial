import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: '[app-categories]',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.scss']
})
export class CategoriesComponent implements OnInit {

	@Input() categories : any;
  constructor() { }

  ngOnInit() {
  }

}
