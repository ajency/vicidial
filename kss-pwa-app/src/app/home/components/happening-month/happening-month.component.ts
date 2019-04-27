import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: '[app-happening-month]',
  templateUrl: './happening-month.component.html',
  styleUrls: ['./happening-month.component.scss']
})
export class HappeningMonthComponent implements OnInit {

	@Input() theme : any;
  constructor(private router: Router) { }

  ngOnInit() {
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  navigateTo(link){
    this.router.navigateByUrl((new URL(link)).pathname);
  }
}
