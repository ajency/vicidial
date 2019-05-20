import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-jaipur',
  templateUrl: './jaipur.component.html',
  styleUrls: ['./jaipur.component.scss']
})
export class JaipurComponent implements OnInit {
  storeImages = [];
  cdnUrl : any;

  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
    this.storeImages = [
      {
          small: this.cdnUrl + 'assets/img/stores/jaipur/jp-store-1-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/jaipur/jp-store-1-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/jaipur/jp-store-1-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/jaipur/jp-store-2-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/jaipur/jp-store-2-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/jaipur/jp-store-2-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/jaipur/jp-store-3-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/jaipur/jp-store-3-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/jaipur/jp-store-3-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/jaipur/jp-store-4-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/jaipur/jp-store-4-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/jaipur/jp-store-4-large.jpg'
      },    
    ];
  }

}
