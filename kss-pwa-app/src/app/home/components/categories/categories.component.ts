import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';
import {BreakpointObserver, Breakpoints} from '@angular/cdk/layout';

declare var $: any;

@Component({
  selector: '[app-categories]',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.scss']
})
export class CategoriesComponent implements OnInit {

	@Input() categories : any;
	catFlag : boolean = false;  
  	isSmallScreen : any;
  	toggleButton = "SHOW MORE";
  constructor(private breakpointObserver : BreakpointObserver) {
    this.isSmallScreen = this.breakpointObserver.isMatched('(max-width: 768px)');
    console.log("isSmallScreen==>", this.isSmallScreen);
  }

  ngOnInit() {
    this.breakpointObserver.observe([
    '(max-width: 768px)'
      ]).subscribe(result => {
        console.log(result);
        if (result.matches) {
          console.log("mobile view");
          this.isSmallScreen = true;
        }else {
          console.log("desktop view");
          this.isSmallScreen = false;
        }
    });
  }

  ngAfterViewInit(){
    if(this.isSmallScreen)
    	this.categoryHeight();
  }

	// isMobileScreen(){
	//   if ($(window).width() < 768)
	//     return true
	//   else
	//     return false
	// }


  categoryHeight(){
    var catHeight = document.getElementById('cat-1').clientHeight;
    var box_height = (catHeight + 64) * 4;
    document.getElementById('home-category').style.height = box_height + 'px';
	   document.getElementById('home-category').classList.add('overflow-h');
    this.catFlag = true;
  }

  showMoreCat(){
  	console.log('show more');
    if(this.catFlag){
      document.getElementById('home-category').style.height = 'auto';
      document.getElementById('home-category').classList.remove('overflow-h');
      // document.getElementById('show-more').innerHTML = 'Show Less';
      this.toggleButton = "SHOW LESS";
      document.getElementById('show-more').classList.add('icon-turn');
      this.catFlag = false;
    }
    else{
      this.categoryHeight();
      // document.getElementById('show-more').innerHTML = 'Show More';
      this.toggleButton = "SHOW MORE";
      document.getElementById('show-more').classList.remove('icon-turn');
    }
  }


}
