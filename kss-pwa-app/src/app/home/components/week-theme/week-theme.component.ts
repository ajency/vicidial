import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: '[app-week-theme]',
  templateUrl: './week-theme.component.html',
  styleUrls: ['./week-theme.component.scss']
})
export class WeekThemeComponent implements OnInit {

	@Input() theme : any;
  constructor(private router: Router,
              private appservice : AppServiceService) { }

  ngOnInit() {
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  navigateTo(link){
    this.router.navigateByUrl(this.appservice.getLink(link));
  }
}
