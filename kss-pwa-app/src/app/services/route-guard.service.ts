import { Injectable } from '@angular/core';
import { Router, CanLoad,  ActivatedRouteSnapshot, RouterStateSnapshot, Route } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class RouteGuardService implements CanLoad{

  constructor(public router: Router) { }

	canLoad(route : Route): boolean {
		if(window.location.pathname == "/"){
			this.router.navigate(['/']);
			return false;
		}
		return true;
	}
}
