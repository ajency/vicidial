import { Component, OnInit, Input, OnChanges } from '@angular/core';
declare var Flickity: any;
declare var $ : any;

@Component({
  selector: 'app-product-img-slider',
  templateUrl: './product-img-slider.component.html',
  styleUrls: ['./product-img-slider.component.scss']
})
export class ProductImgSliderComponent implements OnInit, OnChanges {

  @Input() images : any;
  @Input() attributes : any;
  fadeOut : boolean = false;
  hideLoader : boolean = false;
  constructor() { }

  ngOnInit() {

  }

  ngOnChanges(){
    // console.log("images ==>", this.images);
    if(!this.images.length){
      this.fadeOut = true;
      setTimeout(()=>{
        this.hideLoader = true;
      },500)
    }
  }

  ngAfterViewInit(){
  	// console.log("after view init");
  }

  initSlider(){
    console.log("initSlider");
    let elem = document.querySelector('.prod-slides');
    let options = {
      cellAlign: 'left',
      freeScroll: true,
      contain: true,
      lazyLoad: 5,
      pageDots: false,
      prevNextButtons : true
    }
    if(this.images.length == 1){
      options.prevNextButtons = false;
    }
    let flkty = new Flickity( elem, options);
    let that = this;
    let imageCount = 0;
    flkty.on('lazyLoad', function(event, cellElement) {
        imageCount +=1;
        if(imageCount == that.images.length){
          that.fadeOut = true;
          setTimeout(()=>{
            that.hideLoader = true;
          },500)
        }
    });
  }
}
