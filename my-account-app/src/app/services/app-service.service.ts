import { Injectable } from '@angular/core';

declare var $: any;

@Injectable()
export class AppServiceService {

  constructor() { }


  showLoader(){
    $('.ng-cart-loader').addClass('cart-loader')
  }

  removeLoader(){
    $('.ng-cart-loader').removeClass('cart-loader')
  }

   getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
  }
  closeWidget(){
    console.log('inside closeWidget');
    if(document.getElementsByTagName("body")){
      document.getElementsByTagName("body")[0].classList.remove("hide-scroll");
    }
    if(document.getElementById('cd-my-account'))
      document.getElementById('cd-my-account').classList.remove("speed-in");
    if(document.getElementById('cd-shadow-layer'))
      document.getElementById('cd-shadow-layer').classList.remove('is-visible');
    if(document.getElementsByClassName("modal-backdrop")[0])
      document.getElementsByClassName("modal-backdrop")[0].remove();
  }
}
