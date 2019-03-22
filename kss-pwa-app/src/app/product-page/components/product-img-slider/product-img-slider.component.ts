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
    }
    console.log("options ==>", options);
    let flkty = new Flickity( elem, options);

    flkty.on('lazyLoad', function() {
         this.fadeOut = true;
    });

    // setTimeout(()=>{
    //   flkty.reloadCells();
    // },400)
  }
}
