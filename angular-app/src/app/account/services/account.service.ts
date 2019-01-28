import { Injectable } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';
import { Router, ActivatedRoute} from '@angular/router';

@Injectable()
export class AccountService {

  constructor(private appservice : AppServiceService,
  						private route: ActivatedRoute,
  						public router: Router) { }

  userLogout(){
  	this.appservice.userLogout();
  	this.router.navigate(['account']);
  }
}
