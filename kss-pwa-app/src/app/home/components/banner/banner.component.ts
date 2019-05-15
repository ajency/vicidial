import { Component, OnInit, Input, ViewEncapsulation, OnChanges } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: 'app-banner',
  templateUrl: './banner.component.html',
  styleUrls: ['../../../../../node_modules/ngx-owl-carousel-o/lib/styles/scss/owl.carousel.scss',
              '../../../../../node_modules/ngx-owl-carousel-o/lib/styles/scss/owl.theme.default.scss',
              './banner.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class BannerComponent implements OnInit, OnChanges {

	@Input() banners : any;
  banner_length : any;
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
  cdnUrl : any;
  constructor(private router: Router,
              private appservice : AppServiceService) { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
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

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  navigateTo(link){
    if(this.appservice.getLink(link))
      this.router.navigateByUrl(this.appservice.getLink(link));
    else
      window.location.href = link;
  }

}
