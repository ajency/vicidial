import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-about-us',
  templateUrl: './about-us.component.html',
  styleUrls: ['./about-us.component.scss']
})
export class AboutUsComponent implements OnInit {

  breadcrumbs : any = [
      {position: 1, title: 'Home', url: '/'},
      {position: 2, title: 'About Us', url: '/about-us'},
  ];
  cdnUrl : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
  }

}
