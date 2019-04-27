import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: '[app-brands]',
  templateUrl: './brands.component.html',
  styleUrls: ['./brands.component.scss']
})
export class BrandsComponent implements OnInit {

	@Input() brands : any;
	@Input() brandBanners : any;
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
