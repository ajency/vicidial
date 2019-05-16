import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-surat',
  templateUrl: './surat.component.html',
  styleUrls: ['./surat.component.scss']
})
export class SuratComponent implements OnInit {
  storeImages = [];
  cdnUrl : any;

  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
    this.storeImages = [
      {
          small: this.cdnUrl + 'assets/img/stores/surat/surat8-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/surat/surat8-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/surat/surat8-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/surat/surat1-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/surat/surat1-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/surat/surat1-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/surat/surat2-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/surat/surat2-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/surat/surat2-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/surat/surat3-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/surat/surat3-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/surat/surat3-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/surat/surat4-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/surat/surat4-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/surat/surat4-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/surat/surat5-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/surat/surat5-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/surat/surat5-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/surat/surat6-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/surat/surat6-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/surat/surat6-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/surat/surat7-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/surat/surat7-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/surat/surat7-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/surat/surat9-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/surat/surat9-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/surat/surat9-large.jpg'
      },
      {
          small: this.cdnUrl + 'assets/img/stores/surat/surat10-large.jpg',
          medium: this.cdnUrl + 'assets/img/stores/surat/surat10-small.jpg',
          big: this.cdnUrl + 'assets/img/stores/surat/surat10-large.jpg'
      },
    ];
  }

}
