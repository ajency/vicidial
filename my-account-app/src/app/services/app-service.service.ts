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
}
