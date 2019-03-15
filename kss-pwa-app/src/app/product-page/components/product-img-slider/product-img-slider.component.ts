import { Component, OnInit } from '@angular/core';

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
  }

}
