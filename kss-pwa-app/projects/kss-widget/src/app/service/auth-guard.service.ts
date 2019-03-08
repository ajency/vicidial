import { Injectable } from '@angular/core';
import { Router, CanActivate,  ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { AppServiceService } from './app-service.service';

@Injectable()
export class AuthGuardService implements CanActivate {

  constructor(public router: Router,
							private appservice : AppServiceService) { }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
    if (!this.appservice.isLoggedInUser()) {
      this.router.navigate(['account'], { queryParams: { return_url: state.url }});
      return false;
    }
    return true;
  }
}
