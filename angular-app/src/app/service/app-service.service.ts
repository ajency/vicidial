import { Injectable, isDevMode, EventEmitter, Output } from '@angular/core';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { Subject } from 'rxjs/Subject';
import { ApiServiceService } from './api-service.service';
import * as moment from 'moment';

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
  selectedAddressId : any;
  continueOrder : boolean = false;
  states : any = [];
  editAddressFromShippingSummary : boolean = false;
  addressToEdit : any;

  order : any; // used to pass data to order-details page
  myOrders : any; //used to store list of orders in my-orders page
  redirectUrl : any = '';

  private loginSuccess = new Subject<any>();

  @Output() loginComplete : EventEmitter<boolean> = new EventEmitter();

  navigatingFromBagToAddress : boolean = false;

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
    console.log("closeVerificationModal");
    this.loginComplete.emit();
    // this.loginSuccess.next();
    // this.closeModal.next();
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


  loginSuccessComplete(){
    console.log("loginSuccessComplete for bag view");
    this.loginSuccess.next();
  }

  listenToLoginSuccess() : Observable<any> {    
    return this.loginSuccess.asObservable();
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

  callGetAllAddressesApi(send_cart_id : boolean = false){
    let url = send_cart_id ? this.apiUrl + "/api/rest/v1/user/address/all?cart_id="+this.getCookie('cart_id') : this.apiUrl + "/api/rest/v1/user/address/all";
    let header = this.isLoggedInUser() ? { Authorization : 'Bearer '+this.getCookie('token') } : {};
    return this.apiservice.request(url, 'get', {} , header);
  }

  sortArray(array){
    let return_array = array.sort((a,b)=>{ return(a.min_cart_value - b.min_cart_value)});
    return return_array;
  }

  filterArray(array, order_total){
    let ret_obj = { applicable : [], non_applicable : [] };
    array.forEach((promotion)=>{
      if(promotion.min_cart_value <= order_total)
        ret_obj.applicable.push(promotion);
      else
        ret_obj.non_applicable.push(promotion);
    })
    return ret_obj;
  }

  getAge(vaild_from){
    let now = moment(moment().format('YYYY-MM-DD HH:mm:ss'));
    let start = moment(vaild_from);
    let duration = moment.duration(now.diff(start));
    return duration.asSeconds();
  }

  calculateDiscount(type, value ,order_total){
    return ( type == 'cart_fixed' ? value : (order_total * value / 100) )
  }

  sortByDiscount(array){
    let return_array = array.sort((a,b)=>{ return(b.actual_discount - a.actual_discount) })
    return return_array;
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
