import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: '[app-categories]',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.scss']
})
export class CategoriesComponent implements OnInit {

	@Input() categories : any;
	catFlag : boolean = false;
  constructor() { }

  ngOnInit() {
  }

  ngAfterViewInit(){
  	this.categoryHeight();
  }

  categoryHeight(){
    var catHeight = document.getElementById('cat-1').clientHeight;
    var box_height = (catHeight * 5) + 80;
    document.getElementById('home-category').style.height = box_height + 'px';
	document.getElementById('home-category').classList.add('overflow-h');
    this.catFlag = true;
  }

  showMoreCat(){
  	console.log('show more');
    if(this.catFlag){
      document.getElementById('home-category').style.height = 'auto';
      document.getElementById('home-category').classList.remove('overflow-h');
      document.getElementById('show-more').innerHTML = 'Show Less';
      document.getElementById('show-more').classList.add('icon-turn');
      this.catFlag = false;
    }
    else{
      this.categoryHeight();
      document.getElementById('show-more').innerHTML = 'Show More';
      document.getElementById('show-more').classList.remove('icon-turn');
    }
  }


}
