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
  private openModal = new Subject<any>();
  shippingAddresses = [];
  shippingDetails : any;
  userVerificationComplete : boolean = false;
  directNavigationToShippingAddress : boolean = false;
  selectedAddressId : any;
  continueOrder : boolean = false;
  states : any = [];
  constructor(	private router: Router,
                private apiservice : ApiServiceService) { 
    this.apiUrl = isDevMode() ? 'http://localhost:8000' : '';
    var self = this;
    $('.cd-add-to-cart').on('click',function(){
      self.addToCartClicked();
    });
    $("#cd-cart-trigger").on('click',function(){
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
  }

  addToCartClicked() {
    this.addToCart.next();
  }

  openCartClicked() {
    this.openCart.next();
  }

  closeVerificationModal() {
    this.closeModal.next();
  }

  openVerificationModal(){
    this.openModal.next();
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

  listenToOpenModal() : Observable<any> {
    return this.openModal.asObservable();
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

    this.callMineApi().then((response)=>{
      document.cookie='cart_id=' + response.cart_id + ";path=/";  
    })
    .catch((error)=>{
      console.log("error : mine api ==>", error);
    }) 
  }

  clearSessionStorage(){
    sessionStorage.removeItem('cart_data');
  }

  updateCartCountInUI() {
    //Check if cart count in Session storage
    var cart_count = this.getCookie( "cart_count" );
    if(cart_count && cart_count != "0"){
      $(".cart-counter").removeClass('d-none'), 100;
      $(".cart-counter").addClass('d-block'), 100;
      $('#output').html(function(i, val) { return cart_count });
    }
    else{
      $(".cart-counter").addClass('d-none'), 100;
      $(".cart-counter").removeClass('d-block'), 100;
    }
  }

  userLogout(){
    document.cookie = "cart_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  }

  isLoggedInUser(){
    if(this.getCookie('token') && this.getCookie('cart_id'))
      return true;
    return false;
  }

  callMineApi(){
    let url = this.apiUrl + '/api/rest/v1/user/cart/mine';
    let header = { Authorization : 'Bearer '+this.getCookie('token') };
    return this.apiservice.request(url, 'get', {}, header);
  }

  callFetchCartApi(){
    let url = this.apiUrl + (this.isLoggedInUser() ? ("/api/rest/v1/user/cart/"+this.getCookie('cart_id')+"/get") : ("/rest/v1/anonymous/cart/get"))
    let header = this.isLoggedInUser() ? { Authorization : 'Bearer '+this.getCookie('token') } : {}
    return this.apiservice.request(url, 'get', {}, header);
  }

  callGetAllAddressesApi(){
    let url = this.apiUrl + "/api/rest/v1/user/address/all";
    let header = this.isLoggedInUser() ? { Authorization : 'Bearer '+this.getCookie('token') } : {};
    return this.apiservice.request(url, 'get', {} , header);
  }

}
