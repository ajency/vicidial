import { Injectable, isDevMode } from '@angular/core';
import { Subject } from 'rxjs/Subject';
import { Observable } from 'rxjs';
import { ApiServiceService } from './api-service.service';

declare var $: any;

@Injectable()
export class AppServiceService {
  apiUrl = '';
  redirectUrl : any = '';
  private closeModal = new Subject<any>();
  private openModal = new Subject<any>();

  order : any;
  myOrders : any;
  constructor(private apiservice : ApiServiceService) { 
    this.apiUrl = isDevMode() ? 'http://localhost:8000' : '';
  }

  closeVerificationModal() {
    console.log("AppServiceService closeVerificationModal");
    this.closeModal.next();
  }

  openVerificationModal(){
    this.openModal.next();
  }

  listenToCloseModal() : Observable<any> {
    return this.closeModal.asObservable();
  }

  listenToOpenModal() : Observable<any> {
    return this.openModal.asObservable();
  }

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

  isLoggedInUser(){
    if(this.getCookie('token') && this.getCookie('cart_id'))
      return true;
    return false;
  }

  getOrders(){
      let url = this.apiUrl + '/api/rest/v1/user/orders';
      let header = { Authorization : 'Bearer '+this.getCookie('token') };
      let body : any = {
        _token : $('meta[name="csrf-token"]').attr('content')
      };
      return this.apiservice.request(url, 'post', body , header );
  }

  formattedCartDataForUI(data){
    data.forEach((order)=>{
      order.sub_orders.forEach((sub_order)=>{
        sub_order.items.forEach((item)=>{
          if(item.price_mrp != item.price_final)
            item.off_percentage = Math.round(((item.price_mrp - item.price_final) / (item.price_mrp )) * 100) + '% OFF';
          item.href = '/' + item.product_slug +'/buy?size='+item.size;
          item.images = Array.isArray(item.images) ? ['/img/placeholder.svg', '/img/placeholder.svg', '/img/placeholder.svg'] : Object.values(item.images);
        })
      })
    })
    return data;
  }
}
