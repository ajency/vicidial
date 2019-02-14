import { Component, OnInit, Input, OnChanges } from '@angular/core';

@Component({
  selector: 'app-stories',
  templateUrl: './stories.component.html',
  styleUrls: ['./stories.component.scss']
})
export class StoriesComponent implements OnInit, OnChanges {
	
	@Input() stories : any;
  
  constructor() { }

  ngOnInit() {
  }
  
  ngOnChanges(){
  	console.log("stories ==>", this.stories);
  }

}
