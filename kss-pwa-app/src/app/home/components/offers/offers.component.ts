import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-offers',
  templateUrl: './offers.component.html',
  styleUrls: ['../../../../../node_modules/ngx-owl-carousel-o/lib/styles/scss/owl.carousel.scss',
              '../../../../../node_modules/ngx-owl-carousel-o/lib/styles/scss/owl.theme.default.scss',
              './offers.component.scss']
})
export class OffersComponent implements OnInit {

  @Input() offers : any;
  @Input() banners : any;
  @Input() width : any;
  banner_length : any;
  customOptions: any = {
    loop: false,
    mouseDrag: true,
    touchDrag: true,
    pullDrag: true,
    dots: false,
    navSpeed: 500,
    navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
    autoplay : false,
    //autoplaySpeed : 1000,
    //autoplayTimeout : 5000,
    responsive: {
      0: {
        items: 1,        
      },
      768: {
        items: 3,
        autoWidth: true,
      },
    },   
    nav: true
  }

  constructor() { }

  ngOnInit() {
  }

  ngOnChanges(){
    this.banner_length = this.banners.length;
    console.log("this.banner_length ===>", this.banner_length);
    this.banners = this.banners.filter(banner => banner.element_data.display !== 0)
    if(this.banners.length == 1){
      this.customOptions.loop = false;
      this.customOptions.mouseDrag = false;
      this.customOptions.touchDrag = false;
      this.customOptions.pullDrag = false;
    }
  }

}
