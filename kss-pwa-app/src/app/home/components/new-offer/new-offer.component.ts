import { Component, OnInit, Input  } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-new-offer',
  templateUrl: './new-offer.component.html',
  styleUrls: ['./new-offer.component.scss']
})
export class NewOfferComponent implements OnInit {

	@Input() newOffer : any;
  constructor(private router: Router) { }

  ngOnInit() {
  }

  navigateTo(link){
    this.router.navigateByUrl((new URL(link)).pathname);
  }

}
