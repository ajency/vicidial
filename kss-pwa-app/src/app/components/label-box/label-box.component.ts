import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';
import { AppService } from '../../services/app.service';
import { Router } from '@angular/router';

@Component({
  selector: '[app-label-box]',
  templateUrl: './label-box.component.html',
  styleUrls: ['./label-box.component.scss']
})
export class LabelBoxComponent implements OnInit, OnChanges {
	@Input() box_data : any;
	@Input() box_type : any;
  constructor(private router: Router) { }

  ngOnInit() {
  }

  ngOnChanges(){
    // console.log("label-box ==>", this.box_type);
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  navigateTo(link){
    this.router.navigateByUrl((new URL(link)).pathname);
  }
}
