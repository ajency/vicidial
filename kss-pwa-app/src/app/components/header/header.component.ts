import { Component, OnInit,  Input, OnChanges } from '@angular/core';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit, OnChanges {

	@Input() menu : any;

  constructor(){ }

  ngOnInit(){
  }
  
  ngOnChanges(){
  	console.log("ngOnChanges header", this.menu);
  }
}
