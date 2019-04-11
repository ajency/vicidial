import { Component, OnInit, Input, ViewEncapsulation  } from '@angular/core';

@Component({
  selector: 'app-banner',
  templateUrl: './banner.component.html',
  styleUrls: ['../../../../../node_modules/ngx-owl-carousel-o/lib/styles/scss/owl.carousel.scss',
              '../../../../../node_modules/ngx-owl-carousel-o/lib/styles/scss/owl.theme.default.scss',
              './banner.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class BannerComponent implements OnInit {

	@Input() banners : any;
  customOptions: any = {
    loop: true,
    mouseDrag: true,
    touchDrag: true,
    pullDrag: true,
    dots: false,
    navSpeed: 500,
    navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
    autoplay : true,
    autoplaySpeed : 1000,
    autoplayTimeout : 5000,
    responsive: {
      0: {
        items: 1
      },
      400: {
        items: 1
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
