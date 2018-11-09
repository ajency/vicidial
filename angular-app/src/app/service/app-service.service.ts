import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { isDevMode } from '@angular/core';
import { Observable } from 'rxjs';
import { Subject } from 'rxjs/Subject';
import { ApiServiceService } from './api-service.service';

declare var $: any;

@Injectable()
export class AppServiceService {

  apiUrl = '';
  private addToCart = new Subject<any>();
  private openCart = new Subject<any>();
  private closeModal = new Subject<any>();
  shippingAddresses = [];
  shippingDetails : any;
  userVerificationComplete : boolean = false;
  directNavigationToShippingAddress : boolean = false;
  cartClosedFromShippingPages : boolean = false;
  constructor(	private router: Router,
                private apiservice : ApiServiceService) { 
    console.log("isDevMode ==>",isDevMode());
    this.apiUrl = isDevMode() ? 'http://localhost:8000' : '';
    var self = this;
    $('.cd-add-to-cart').on('click',function(){
      console.warn("appservice ==========> add to cart clicked");
      // self.router.navigateByUrl('/cartpage', { skipLocationChange: true });
      self.addToCartClicked();
    });
    $("#cd-cart-trigger").on('click',function(){
      console.warn("appservice ==========> open to cart clicked");
      // self.router.navigateByUrl('/cartpage', { skipLocationChange: true });
      self.openCartClicked();
    });
  }

  closeCart(){
  	console.log('inside closeCart');
    if(document.getElementsByTagName("body")){
      document.getElementsByTagName("body")[0].classList.remove("hide-scroll");
    }
    if(document.getElementById('cd-cart'))
      document.getElementById('cd-cart').classList.remove("speed-in");
    if(document.getElementById('cd-shadow-layer'))
      document.getElementById('cd-shadow-layer').classList.remove('is-visible');
    if(document.getElementsByClassName("modal-backdrop")[0])
	    document.getElementsByClassName("modal-backdrop")[0].remove();
    // this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
  }

  addToCartClicked() {
    console.log("triggerEvent");
    this.addToCart.next();
  }

  openCartClicked() {
    this.openCart.next();
      // this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
  }

  closeVerificationModal() {
    this.closeModal.next()
  }

  listenToAddToCartEvent(): Observable<any> {
    return this.addToCart.asObservable();
  }

  listenToOpenCartEvent() : Observable<any> {
    return this.openCart.asObservable();
  }

  listenToCloseModal() : Observable<any> {
    return this.closeModal.asObservable();
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

  showLoader(){
    $('.ng-cart-loader').addClass('cart-loader')
  }

  removeLoader(){
    $('.ng-cart-loader').removeClass('cart-loader')
  }

  updateCartId(){
    this.clearSessionStorage();
    document.cookie='cart_count=' + 0 + ";path=/";
    this.updateCartCountInUI();
    let url = this.apiUrl + '/api/rest/v1/user/cart/mine';
    let header = { Authorization : 'Bearer '+this.getCookie('token') };

    this.apiservice.request(url, 'get', {} , header ).then((response)=>{
      console.log("response ==>", response);
      document.cookie='cart_id=' + response.cart_id + ";path=/";         
    })
    .catch((error)=>{
      console.log("error ===>", error);
    })  
  }

  clearSessionStorage(){
    sessionStorage.removeItem('cart_data');
  }

  updateCartCountInUI() {
    //Check if cart count in Session storage
    var cart_count = this.getCookie( "cart_count" );
    if(cart_count && cart_count != "0"){
      //Scroll to top if cart icon is hidden on top
      $(".cart-counter").removeClass('d-none'), 100;
      $(".cart-counter").addClass('d-block'), 100;
      $('#output').html(function(i, val) { return cart_count });
    }
    else{
      $(".cart-counter").addClass('d-none'), 100;
      $(".cart-counter").removeClass('d-block'), 100;
    }
  }
}
