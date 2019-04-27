import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-jaipur',
  templateUrl: './jaipur.component.html',
  styleUrls: ['./jaipur.component.scss']
})
export class JaipurComponent implements OnInit {

  storeImages = [
    {
        small: '../../../assets/img/stores/jaipur/jp-store-1-large.jpg',
        medium: '../../../assets/img/stores/jaipur/jp-store-1-small.jpg',
        big: '../../../assets/img/stores/jaipur/jp-store-1-large.jpg'
    },
    {
        small: '../../../assets/img/stores/jaipur/jp-store-2-large.jpg',
        medium: '../../../assets/img/stores/jaipur/jp-store-2-small.jpg',
        big: '../../../assets/img/stores/jaipur/jp-store-2-large.jpg'
    },
    {
        small: '../../../assets/img/stores/jaipur/jp-store-3-large.jpg',
        medium: '../../../assets/img/stores/jaipur/jp-store-3-small.jpg',
        big: '../../../assets/img/stores/jaipur/jp-store-3-large.jpg'
    },
    {
        small: '../../../assets/img/stores/jaipur/jp-store-4-large.jpg',
        medium: '../../../assets/img/stores/jaipur/jp-store-4-small.jpg',
        big: '../../../assets/img/stores/jaipur/jp-store-4-large.jpg'
    },    
  ];

  constructor() { }

  ngOnInit() {
  }

}
