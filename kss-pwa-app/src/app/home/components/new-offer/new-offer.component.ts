import { Component, OnInit, Input  } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: 'app-new-offer',
  templateUrl: './new-offer.component.html',
  styleUrls: ['./new-offer.component.scss']
})
export class NewOfferComponent implements OnInit {

	@Input() newOffer : any;
  constructor(private router: Router,
              private appservice : AppServiceService) { }

  ngOnInit() {
  }

  navigateTo(link){
    this.router.navigateByUrl(this.appservice.getLink(link));
  }

}
