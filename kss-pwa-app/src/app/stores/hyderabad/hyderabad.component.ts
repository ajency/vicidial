import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-hyderabad',
  templateUrl: './hyderabad.component.html',
  styleUrls: ['./hyderabad.component.scss']
})
export class HyderabadComponent implements OnInit {

  storeImages = [
    {
        small: '../../../assets/img/stores/hyderabad/hyderabad3-large.jpg',
        medium: '../../../assets/img/stores/hyderabad/hyderabad3-small.jpg',
        big: '../../../assets/img/stores/hyderabad/hyderabad3-large.jpg'
    },
    {
        small: '../../../assets/img/stores/hyderabad/hyderabad1-large.jpg',
        medium: '../../../assets/img/stores/hyderabad/hyderabad1-small.jpg',
        big: '../../../assets/img/stores/hyderabad/hyderabad1-large.jpg'
    },
    {
        small: '../../../assets/img/stores/hyderabad/hyderabad2-large.jpg',
        medium: '../../../assets/img/stores/hyderabad/hyderabad2-small.jpg',
        big: '../../../assets/img/stores/hyderabad/hyderabad2-large.jpg'
    },
    {
        small: '../../../assets/img/stores/hyderabad/hyderabad14-large.jpg',
        medium: '../../../assets/img/stores/hyderabad/hyderabad14-small.jpg',
        big: '../../../assets/img/stores/hyderabad/hyderabad14-large.jpg'
    },    
  ];

  constructor() { }

  ngOnInit() {
  }

}
