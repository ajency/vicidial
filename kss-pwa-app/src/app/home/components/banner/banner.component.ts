import { Component, OnInit, Input  } from '@angular/core';

@Component({
  selector: 'app-banner',
  templateUrl: './banner.component.html',
  styleUrls: ['./banner.component.scss']
})
export class BannerComponent implements OnInit {

	@Input() banners : any;
  customOptions: any = {
    loop: true,
    mouseDrag: false,
    touchDrag: false,
    pullDrag: false,
    dots: false,
    navSpeed: 700,
    navText: ['prev', 'next'],
    autoplay : true,
    autoplaySpeed : 1000,
    responsive: {
      0: {
        items: 1
      },
      400: {
        items: 2
      },
      740: {
        items: 1
      },
      940: {
        items: 1
      }
    },
    nav: true
  }
  constructor() { }

  ngOnInit() {
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

}
