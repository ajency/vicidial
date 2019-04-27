import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-gender-category',
  templateUrl: './gender-category.component.html',
  styleUrls: ['./gender-category.component.scss']
})
export class GenderCategoryComponent implements OnInit {

	@Input() tabs : any;
  constructor(private router: Router) { }

  ngOnInit() {
    
  }

  ngOnChanges(){

  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  navigateTo(link){
    this.router.navigateByUrl((new URL(link)).pathname);
  }

}
