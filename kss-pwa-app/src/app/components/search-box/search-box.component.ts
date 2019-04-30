import { Component, OnInit, Input, Output, EventEmitter, OnChanges } from '@angular/core';

@Component({
  selector: 'app-search-box',
  templateUrl: './search-box.component.html',
  styleUrls: ['./search-box.component.scss']
})
export class SearchBoxComponent implements OnInit, OnChanges {
	@Output() updateList = new EventEmitter();
	@Input() defaultText : any;
	searchText : any;
  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
  	console.log("ngOnChanges");
  	if(this.defaultText)
  		this.searchText = this.defaultText;
  }

  searchProduct(){
  	console.log("searchProduct ==>", this.searchText);
  	if(this.searchText != this.defaultText)
  		this.updateList.emit(this.searchText);
  }

  clearSearch(){
    this.searchText = '';
    this.searchProduct();
  }

  enterclick(event){
    if (event.keyCode === 13) {
        this.searchProduct();
    }
  }
}
