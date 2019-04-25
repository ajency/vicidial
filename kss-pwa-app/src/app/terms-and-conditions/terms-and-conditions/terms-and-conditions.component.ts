import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-terms-and-conditions',
  templateUrl: './terms-and-conditions.component.html',
  styleUrls: ['./terms-and-conditions.component.scss']
})
export class TermsAndConditionsComponent implements OnInit {

  breadcrumbs : any = [
    {position: 1, title: 'Home', url: '/'},
    {position: 2, title: 'Terms and Conditions', url: ''},
  ];

  constructor() { }

  ngOnInit() {
  }

}
