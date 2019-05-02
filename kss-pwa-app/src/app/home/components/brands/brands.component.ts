import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: '[app-brands]',
  templateUrl: './brands.component.html',
  styleUrls: ['./brands.component.scss']
})
export class BrandsComponent implements OnInit {

	@Input() brands : any;
	@Input() brandBanners : any;
  constructor(private router: Router,
              private appservice : AppServiceService) { }

  ngOnInit() {
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  navigateTo(link){
    if(this.appservice.getLink(link))
      this.router.navigateByUrl(this.appservice.getLink(link));
    else
      window.location.href = link;
  }

}
