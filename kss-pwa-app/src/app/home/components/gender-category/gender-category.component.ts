import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: 'app-gender-category',
  templateUrl: './gender-category.component.html',
  styleUrls: ['./gender-category.component.scss']
})
export class GenderCategoryComponent implements OnInit {

	@Input() tabs : any;
  constructor(private router: Router,
              private appservice : AppServiceService) { }

  ngOnInit() {
    
  }

  ngOnChanges(){

  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  navigateTo(link){
    this.router.navigateByUrl(this.appservice.getLink(link));
  }

}
