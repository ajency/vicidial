import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { isDevMode } from '@angular/core';

@Injectable()
export class AppServiceService {

  apiUrl = '';
  constructor(	private router: Router ) { 
    console.log("isDevMode ==>",isDevMode());
    this.apiUrl = isDevMode() ? 'http://localhost:8000' : '';
  }

  closeCart(){
  	console.log('inside closeCart');
    if(document.getElementsByTagName("body"))
      document.getElementsByTagName("body")[0].classList.remove("hide-scroll");
    if(document.getElementById('cd-cart'))
      document.getElementById('cd-cart').classList.remove("speed-in");
    if(document.getElementById('cd-shadow-layer'))
      document.getElementById('cd-shadow-layer').classList.remove('is-visible');
    if(document.getElementsByClassName("modal-backdrop")[0])
	    document.getElementsByClassName("modal-backdrop")[0].remove();
    this.router.navigateByUrl('/', { skipLocationChange: true });
  }
}
