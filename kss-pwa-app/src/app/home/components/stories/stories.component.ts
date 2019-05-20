import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';
import {BreakpointObserver, Breakpoints} from '@angular/cdk/layout';

@Component({
  selector: 'app-stories',
  templateUrl: './stories.component.html',
  styleUrls: ['./stories.component.scss']
})
export class StoriesComponent implements OnInit, OnChanges, AfterViewInit {

	@Input() stories : any;
  catFlag : boolean = false;  
  isSmallScreen : any;
  toggleButton = "SHOW MORE";
  cdnUrl : any;
  @Output() storiesLoaded = new EventEmitter();
  constructor(private breakpointObserver : BreakpointObserver,
              private appservice : AppServiceService) {
    this.isSmallScreen = this.breakpointObserver.isMatched('(max-width: 600px)');
    // console.log("isSmallScreen==>", this.isSmallScreen);
  }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
    this.breakpointObserver.observe([
    '(max-width: 600px)'
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

  ngOnChanges(){
  	// console.log("stories ==>", this.stories);
  }

  ngAfterViewInit(){
    console.log("ngAfterViewInit stories component");
    this.storiesLoaded.emit(true);
    if(this.isSmallScreen)
      this.storyHeight();
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  storyHeight(){
    var catHeight = document.getElementById('story-1').clientHeight;
    var box_height = (catHeight + 56 ) * 6;
    document.getElementById('home-story').style.height = box_height + 'px';
     document.getElementById('home-story').classList.add('overflow-h');
    this.catFlag = true;
  }

  showMoreStory(){
    console.log('show more');
    if(this.catFlag){
      document.getElementById('home-story').style.height = 'auto';
      document.getElementById('home-story').classList.remove('overflow-h');
      // document.getElementById('show-more').innerHTML = 'Show Less';
      this.toggleButton = "SHOW LESS";
      document.getElementById('show-more-story').classList.add('icon-turn');
      this.catFlag = false;
    }
    else{
      this.storyHeight();
      // document.getElementById('show-more').innerHTML = 'Show More';
      this.toggleButton = "SHOW MORE";
      document.getElementById('show-more-story').classList.remove('icon-turn');
    }
  }

}
