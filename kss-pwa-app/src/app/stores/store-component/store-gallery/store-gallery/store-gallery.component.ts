import { Component, OnInit, Input } from '@angular/core';
import { NgxGalleryOptions, NgxGalleryImage, NgxGalleryAnimation } from 'ngx-gallery';

@Component({
  selector: 'app-store-gallery',
  templateUrl: './store-gallery.component.html',
  styleUrls: ['./store-gallery.component.scss']
})
export class StoreGalleryComponent implements OnInit {
  @Input() gallery: any;
  galleryOptions: NgxGalleryOptions[];
  galleryImages: NgxGalleryImage[];

  constructor() { }

  ngOnInit() : void {
 
      this.galleryOptions = [
          {
              width: '100%',
              height: '578px',
              thumbnailsColumns: 4,
              imageAnimation: NgxGalleryAnimation.Slide,
              preview: false,
              imageInfinityMove: true,
              thumbnailsArrows: false,
              imageSwipe: true,
              thumbnailsMargin: 20,
              thumbnailMargin: 20
          },
          {
            breakpoint: 991,
            height: '460px',
          },
          {
            breakpoint: 767,
            height: '400px',
          },
          {
            breakpoint: 420,
            height: '225px',
          }
      ];
  }

}
