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
    var elem = document.querySelector('.prod-slides');
    var flkty = new Flickity( elem, {
        // options
        cellAlign: 'left',
        freeScroll: true,
        contain: true,
        lazyLoad: 2,
        pageDots: false
    });
    
    setTimeout(()=>{
      flkty.reloadCells();
      if(this.images.length == 1) {
         $('.flickity-button').hide();
     }
    },400)
  }
}
