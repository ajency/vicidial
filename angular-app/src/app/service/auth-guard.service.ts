import { Injectable } from '@angular/core';
import { Router, CanActivate } from '@angular/router';
import { AppServiceService } from './app-service.service';

@Injectable()
export class AuthGuardService implements CanActivate {

  constructor(public router: Router,
  						private appservice : AppServiceService) { }

  canActivate(): boolean {
    if (!this.appservice.isLoggedInUser()) {
      this.router.navigate(['account']);
      return false;
    }
    return true;
  }
}
