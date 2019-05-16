import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-hyderabad',
  templateUrl: './hyderabad.component.html',
  styleUrls: ['./hyderabad.component.scss']
})
export class HyderabadComponent implements OnInit {
  storeImages = [];
  cdnUrl : any;

  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
    this.storeImages = [
      {
          small: this.cdnUrl + 'assets/img/stores/hyderabad/hyderabad3-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/hyderabad/hyderabad3-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/hyderabad/hyderabad3-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/hyderabad/hyderabad1-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/hyderabad/hyderabad1-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/hyderabad/hyderabad1-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/hyderabad/hyderabad2-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/hyderabad/hyderabad2-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/hyderabad/hyderabad2-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/hyderabad/hyderabad14-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/hyderabad/hyderabad14-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/hyderabad/hyderabad14-large.jpg'
      },    
    ];
  }

}
