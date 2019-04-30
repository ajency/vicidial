import { Component, OnInit, ViewChild, ElementRef } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { Subscription } from 'rxjs';
@Component({
  selector: 'app-terms-and-conditions',
  templateUrl: './terms-and-conditions.component.html',
  styleUrls: ['./terms-and-conditions.component.scss']
})
export class TermsAndConditionsComponent implements OnInit {

  breadcrumbs : any = [
    {position: 1, title: 'Home', url: '/'},
    {position: 2, title: 'Terms and Conditions', url: '/terms-and-conditions'},
  ];

  @ViewChild('shipping') shipping : ElementRef;
  @ViewChild('return') return : ElementRef;
  @ViewChild('cancellation') cancellation : ElementRef;
  routeSubscribtion:Subscription
  constructor(private route : ActivatedRoute) { }

  ngOnInit() {
    this.routeSubscribtion = this.route.fragment.subscribe(fragment => { 
      console.log(fragment);
      if(fragment == 'shipping')
        this.shipping.nativeElement.scrollIntoView()
      if(fragment == 'return')
        this.return.nativeElement.scrollIntoView()
      if(fragment == 'cancellation')
        this.cancellation.nativeElement.scrollIntoView()
    });
  }

  ngOnDestroy(){
    this.routeSubscribtion.unsubscribe()
  }
}
