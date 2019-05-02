import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';
import {BreakpointObserver, Breakpoints} from '@angular/cdk/layout';
@Component({
  selector: 'app-offers',
  templateUrl: './offers.component.html',
  styleUrls: ['../../../../../node_modules/ngx-owl-carousel-o/lib/styles/scss/owl.carousel.scss',
              '../../../../../node_modules/ngx-owl-carousel-o/lib/styles/scss/owl.theme.default.scss',
              './offers.component.scss']
})
export class OffersComponent implements OnInit {

  @Input() offers : any;
  @Input() width : any;
  offer_length : any;
  customOptions: any = {
    loop: true,
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
  isMobile : boolean = false;

  constructor(private breakpointObserver : BreakpointObserver) {
    this.isMobile = this.breakpointObserver.isMatched('(max-width: 768px)');
  }

  ngOnInit() {
  }

  ngOnChanges(){
    this.offer_length = this.offers.length;
    console.log("this.offer_length ===>", this.offer_length);
    this.offers = this.offers.filter(offer => offer.element_data.display !== 0)

    if((this.offers.length < 4 && !this.isMobile) || (this.isMobile && this.offers.length == 1)){
      this.customOptions.loop = false;
      this.customOptions.mouseDrag = false;
      this.customOptions.touchDrag = false;
      this.customOptions.pullDrag = false;
    }
  }

}
