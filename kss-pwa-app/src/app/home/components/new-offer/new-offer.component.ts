import { Component, OnInit, Input  } from '@angular/core';

@Component({
  selector: 'app-new-offer',
  templateUrl: './new-offer.component.html',
  styleUrls: ['./new-offer.component.scss']
})
export class NewOfferComponent implements OnInit {

	@Input() newOffer : any;
  constructor() { }

  ngOnInit() {
  }

}
