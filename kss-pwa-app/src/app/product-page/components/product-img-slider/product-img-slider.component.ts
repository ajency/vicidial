import { Component, OnInit } from '@angular/core';
declare var Flickity: any;

@Component({
  selector: 'app-product-img-slider',
  templateUrl: './product-img-slider.component.html',
  styleUrls: ['./product-img-slider.component.scss']
})
export class ProductImgSliderComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  	
  }

  ngAfterViewInit(){
  	console.log("after view init");
    var elem = document.querySelector('.prod-slides');
    var flkty = new Flickity( elem, {
      // options
      cellAlign: 'left',
      freeScroll: true,
      contain: true,
      lazyLoad: 2,
      pageDots: false
    });
  }

}
