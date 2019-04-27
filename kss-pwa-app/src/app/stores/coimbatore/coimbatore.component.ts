import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-coimbatore',
  templateUrl: './coimbatore.component.html',
  styleUrls: ['./coimbatore.component.scss']
})
export class CoimbatoreComponent implements OnInit {

  storeImages = [
    {
        small: '../../../assets/img/stores/coimbatore/coimbatore1-large.jpg',
        medium: '../../../assets/img/stores/coimbatore/coimbatore1-small.jpg',
        big: '../../../assets/img/stores/coimbatore/coimbatore-large.jpg'
    },
    {
        small: '../../../assets/img/stores/coimbatore/coimbatore2-large.jpg',
        medium: '../../../assets/img/stores/coimbatore/coimbatore2-small.jpg',
        big: '../../../assets/img/stores/coimbatore/coimbatore2-large.jpg'
    },
    {
        small: '../../../assets/img/stores/coimbatore/coimbatore3-large.jpg',
        medium: '../../../assets/img/stores/coimbatore/coimbatore3-small.jpg',
        big: '../../../assets/img/stores/coimbatore/coimbatore3-large.jpg'
    },
    {
        small: '../../../assets/img/stores/coimbatore/coimbatore4-large.jpg',
        medium: '../../../assets/img/stores/coimbatore/coimbatore4-small.jpg',
        big: '../../../assets/img/stores/coimbatore/coimbatore4-large.jpg'
    },
    {
        small: '../../../assets/img/stores/coimbatore/coimbatore5-large.jpg',
        medium: '../../../assets/img/stores/coimbatore/coimbatore5-small.jpg',
        big: '../../../assets/img/stores/coimbatore/coimbatore5-large.jpg'
    },
    {
        small: '../../../assets/img/stores/coimbatore/coimbatore6-large.jpg',
        medium: '../../../assets/img/stores/coimbatore/coimbatore6-small.jpg',
        big: '../../../assets/img/stores/coimbatore/coimbatore6-large.jpg'
    },
    {
        small: '../../../assets/img/stores/coimbatore/coimbatore7-large.jpg',
        medium: '../../../assets/img/stores/coimbatore/coimbatore7-small.jpg',
        big: '../../../assets/img/stores/coimbatore/coimbatore7-large.jpg'
    },
    {
        small: '../../../assets/img/stores/coimbatore/coimbatore8-large.jpg',
        medium: '../../../assets/img/stores/coimbatore/coimbatore8-small.jpg',
        big: '../../../assets/img/stores/coimbatore/coimbatore8-large.jpg'
    },
    {
        small: '../../../assets/img/stores/coimbatore/coimbatore9-large.jpg',
        medium: '../../../assets/img/stores/coimbatore/coimbatore9-small.jpg',
        big: '../../../assets/img/stores/coimbatore/coimbatore9-large.jpg'
    },
  ];

  constructor() { }

  ngOnInit() {
  }

}
