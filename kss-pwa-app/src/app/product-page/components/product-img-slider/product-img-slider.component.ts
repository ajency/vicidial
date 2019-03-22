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
      lazyLoad: 1,
      pageDots: false,
      prevNextButtons : true
    }
    if(!this.images.length){
      options.prevNextButtons = false;
      this.fadeOut = true;
      setTimeout(()=>{
        this.hideLoader = true;
      },500)
    }
    console.log("options ==>", options);
    let flkty = new Flickity( elem, options);
    let slideLoader = this;
    flkty.on('lazyLoad', function(event, cellElement) {
        slideLoader.fadeOut = true;
        console.log(this);
        setTimeout(()=>{
          slideLoader.hideLoader = true;
        },500)
    });


  }
}
