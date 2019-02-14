import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-stories',
  templateUrl: './stories.component.html',
  styleUrls: ['./stories.component.scss']
})
export class StoriesComponent implements OnInit, OnChanges, AfterViewInit {
	
	@Input() stories : any;
  @Output() storiesLoaded = new EventEmitter();
  constructor() { }

  ngOnInit() {
  }
  
  ngOnChanges(){
  	console.log("stories ==>", this.stories);
  }

  ngAfterViewInit(){
    console.log("ngAfterViewInit stories component");
    this.storiesLoaded.emit(true);
  }

}
