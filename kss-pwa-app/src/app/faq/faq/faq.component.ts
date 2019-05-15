import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-faq',
  templateUrl: './faq.component.html',
  styleUrls: ['./faq.component.scss']
})
export class FaqComponent implements OnInit {

  breadcrumbs : any = [
    {position: 1, title: 'Home', url: '/'},
    {position: 2, title: 'Faq', url: '/faq'},
  ];
  cdnUrl : any;
  constructor() { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
  }

}
