import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';
import { Router } from '@angular/router';

@Component({
  selector: '[app-label-box]',
  templateUrl: './label-box.component.html',
  styleUrls: ['./label-box.component.scss']
})
export class LabelBoxComponent implements OnInit, OnChanges {
	@Input() box_data : any;
	@Input() box_type : any;
  cdnUrl : any;
  constructor(private router: Router,
              private appservice : AppServiceService) { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
  }

  ngOnChanges(){
    // console.log("label-box ==>", this.box_type);
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
