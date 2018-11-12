import { Component, OnInit, NgZone } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import { Subscription } from 'rxjs/Subscription';
// import * as $ from 'jquery';
declare var $: any;

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.css']
})
export class CartComponent implements OnInit {

  mobileNumberEntered = false;
  enterCoupon = false;
  cart : any = {};
  sessionCheckInterval : any;
  cartOpen = false;
  mobileNumber : any;
  otp : any;
  otpCode = {otp1:"",otp2:"",otp3:"",otp4:"",otp5:"",otp6:""}
  userValidation = {
    disableSendOtpButton :  false,
    mobileValidationFailed : false,
    mobileValidationErrorMsg : '',
    disableVerifyOtpButton : false,
    otpVerificationFailed : false,
    otpVerificationErrorMsg : ''
  }
  reloadSubscription: Subscription;
  loadSubscription: Subscription;
  closeModalSubscription: Subscription;
  cartItemOutOfStock : boolean = false;
  fetchCartFailed : boolean = false;
  constructor( private router: Router,
               private appservice : AppServiceService,
               private apiservice : ApiServiceService,
               private zone : NgZone
              ) { 
    this.reloadSubscription = this.appservice.listenToAddToCartEvent().subscribe(()=> { this.reloadCart() });
    this.loadSubscription = this.appservice.listenToOpenCartEvent().subscribe(()=> { this.loadCart() });

    this.closeModalSubscription = this.appservice.listenToCloseModal().subscribe(()=>{ this.updateOtpModal(false)});
  }

  reloadCart(){
    this.updateUrl();
    console.log("listened to the add to cart trigger");
    this.cartOpen = true;
    this.fetchCartDataOnAddToCartSuccess();
    sessionStorage.removeItem('add_to_cart_clicked');
  }

  loadCart(){
    this.updateUrl();
    console.log("listened to open cart trigger");
    this.cartOpen = true;
    this.getCartData();
  }

  ngOnDestroy() {
  // unsubscribe to ensure no memory leaks
    this.reloadSubscription.unsubscribe();
    this.loadSubscription.unsubscribe()
  }

  ngOnInit() {
    if(this.appservice.cartClosedFromShippingPages)
      this.appservice.cartClosedFromShippingPages = false;
    else{
      console.log("ngOnInit cart component");   
      this.updateUrl();
      this.cartOpen = true;
      $('.ng-cart-loader').removeClass('cart-loader')
      if(sessionStorage.getItem('add_to_cart_clicked')){
        console.log("add to cart clicked");
        this.fetchCartDataOnAddToCartSuccess();
        sessionStorage.removeItem('add_to_cart_clicked');
      }
      else{
        this.getCartData();
      }
    }
  }

  ngAfterViewInit(){
    if(window.location.href.endsWith('/user-verification'))
      this.modalHandler();
  }

  updateUrl(){
    let url = window.location.href.split("#")[0] + '#bag';
    if(window.location.href.endsWith('#shipping-address') || window.location.href.endsWith('#shipping-summary'))
      history.replaceState({cart : true}, 'cart', url);
    else if(!(window.location.href.endsWith('#bag') || window.location.href.endsWith('#bag/user-verification')))
      history.pushState({cart : true}, 'cart', url);
  }

  fetchCartDataOnAddToCartSuccess(){    
    this.appservice.showLoader()
    if(sessionStorage.getItem('cart_data')){
      this.cart = JSON.parse(sessionStorage.getItem('cart_data'));
      console.log("cart_data from sessionStorage==>", this.cart);
    }
    else
      this.cart = {};
    
    this.sessionCheckInterval = setInterval(()=>{
      if(sessionStorage.getItem('addded_to_cart')){
        this.fetchCartDataFromServer();
        sessionStorage.removeItem('addded_to_cart');
        clearInterval(this.sessionCheckInterval);
      }
    this.zone.run(() => {});
    },100)
    this.zone.run(() => {});
  }

  getCartData(){
    this.appservice.showLoader()
    if(sessionStorage.getItem('cart_data')){
      this.cart = JSON.parse(sessionStorage.getItem('cart_data'));
      console.log("cart_data from sessionStorage==>", this.cart);
    }
    this.fetchCartDataFromServer();
  }

  fetchCartDataFromServer(){
    this.appservice.showLoader()
    let url = this.appservice.apiUrl + (this.isLoggedInUser() ? ("/api/rest/v1/user/cart/"+this.appservice.getCookie('cart_id')+"/get") : ("/rest/v1/anonymous/cart/get"))
    console.log(this.isLoggedInUser());
    let header = this.isLoggedInUser() ? { Authorization : 'Bearer '+this.appservice.getCookie('token') } : {}
    this.apiservice.request(url, 'get', {}, header ).then((response)=>{
      console.log("response ==>", response);
      this.cart = this.calculateOffPercenatge(response);
      this.checkCartItemOutOfStock();
      sessionStorage.setItem('cart_data', JSON.stringify(this.cart));
      document.cookie = "cart_count=" + this.cart.cart_count + ";path=/";
      this.appservice.updateCartCountInUI();
      this.appservice.removeLoader();
      this.fetchCartFailed = false;
      this.zone.run(() => {});
    })
    .catch((error)=>{
      console.log("error ===>", error);
      if(error.status == 401){
        this.appservice.userLogout();
        this.fetchCartDataFromServer();
        this.fetchCartFailed = false; 
      }
      else if((error.status == 400 || error.status == 403) && this.isLoggedInUser() ){
        this.getNewCartId();
        this.fetchCartFailed = false; 
      }
      else if(error.status == 404){
        this.cart = {
          items : []
        }
        this.fetchCartFailed = false;        
      }
      else{
        this.cart = {};
        this.fetchCartFailed = true;
      }
      this.appservice.removeLoader()
      this.zone.run(() => {});
    })
    this.zone.run(() => {});
  }

  calculateOffPercenatge(data){
    data.items.forEach((item)=>{
      if(item.attributes.price_mrp != item.attributes.price_final)
        item.off_percentage = Math.round(((item.attributes.price_mrp - item.attributes.price_final) / (item.attributes.price_mrp )) * 100) + '% OFF';
      item.href = '/' + item.product_slug +'/buy?size='+item.attributes.size;
      item.attributes.images = Array.isArray(item.attributes.images) ? ['/img/placeholder.svg', '/img/placeholder.svg', '/img/placeholder.svg'] : Object.values(item.attributes.images);
    })

    data.items.sort((a,b)=>{ return a.timestamp - b.timestamp});
    data.items.reverse();
    return data;
  }

  isLoggedInUser(){
    if(this.appservice.getCookie('token') && this.appservice.getCookie('cart_id'))
      return true;
    return false;
  }

  modifyCart(item){
    // console.log("inside modifyCart function ==>", item);
    // let body;
    // body = {
    //   old_item : item.id,
    //   new_item : item.related_items.size.find(size=> size.value == item.attributes.size).id,
    //   quantity : item.quantity
    // }
    // console.log("Body ==>", body);
    // let url = 'http://localhost:8000/rest/v1/anonymous/cart/update';
    // this.apiservice.request(url, 'get', body ).then((response)=>{
    //   console.log("response ==>", response);
    //   item = response.item;
    //   sessionStorage.setItem('cart_data', JSON.stringify(this.cart));
    // })
    // .catch((error)=>{
    //   console.log("error ===>", error);
    // })
  }

  deleteItem(item){
    this.appservice.showLoader()
    console.log("delete item ==>", item);
    let body = { variant_id : item.id };
    let url = this.appservice.apiUrl + (this.isLoggedInUser() ? ("/api/rest/v1/user/cart/"+this.appservice.getCookie('cart_id')+"/delete?") : ("/rest/v1/anonymous/cart/delete?"));
    let header = this.isLoggedInUser() ? { Authorization : 'Bearer '+this.appservice.getCookie('token') } : {};
    url = url+$.param(body);
    this.apiservice.request(url, 'get', body, header ).then((response)=>{
      console.log("response ==>", response);
      let index = this.cart.items.findIndex(i => i.id == item.id)
      this.cart.items.splice(index,1);
      this.cart.summary = response.summary;
      this.cart.cart_count = response.cart_count;
      this.checkCartItemOutOfStock();
      document.cookie = "cart_count=" + this.cart.cart_count + ";path=/";
      sessionStorage.setItem('cart_data', JSON.stringify(this.cart));
      this.appservice.updateCartCountInUI();
      this.appservice.removeLoader()
    })
    .catch((error)=>{
      console.log("error ===>", error);
      if(error.status == 401){
        this.appservice.userLogout();
        this.fetchCartDataFromServer();
        this.fetchCartFailed = false; 
      }
      else if((error.status == 400 || error.status == 403) && this.isLoggedInUser() ){
        this.getNewCartId();
        this.fetchCartFailed = false; 
      }
      this.appservice.removeLoader();
    })
  }

  enterclick(event){
      if (event.keyCode === 13) {
        $('.is-enter').click();
      }
  }

  authenticateUser(){
    this.userValidation.disableSendOtpButton = true;
    this.userValidation.mobileValidationFailed = false;
    // this.appservice.apiUrl = 'http://demo8558685.mockable.io/';
    let url = this.appservice.apiUrl + '/rest/v1/authenticate/generate_otp?';
    let body = {
      phone : this.mobileNumber
    }
    url = url+$.param(body);
    this.apiservice.request(url, 'get', body , {}, true).then((response)=>{
      console.log("response ==>", response);
      this.userValidation.disableSendOtpButton = false;
      if(response.success){
        this.mobileNumberEntered = true;
      }
      else{
        this.userValidation.mobileValidationFailed = true;
        this.userValidation.mobileValidationErrorMsg = response.message
      }

    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.userValidation.disableSendOtpButton = false;
      this.userValidation.mobileValidationFailed = true;
    })
  }

  verifyMobile(){
    this.userValidation.disableVerifyOtpButton = true;
    this.userValidation.otpVerificationFailed = false;
    let url = this.appservice.apiUrl + '/rest/v1/authenticate/login?';
    // this.otp=this.otpCode.otp1+this.otpCode.otp2+this.otpCode.otp3+this.otpCode.otp4+this.otpCode.otp5+this.otpCode.otp6
    console.log("OTP ==>", this.otp);
    let body = {
      otp : this.otp,
      phone : this.mobileNumber
    }
    url = url + $.param(body);
    this.apiservice.request(url, 'get', body, {}, true).then((response)=>{
      console.log("response ==>", response);
      this.otp = null;
      this.userValidation.disableVerifyOtpButton = false;
      if(response.success){
        document.cookie='token='+ response.token + ";path=/";
        document.cookie='cart_id=' + response.user.active_cart_id + ";path=/";
        this.appservice.userVerificationComplete = true;
        this.navigateToShippingDetailsPage();        
      }
      else{
        this.userValidation.otpVerificationErrorMsg = response.message;
        this.userValidation.otpVerificationFailed = true;
      }

    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.userValidation.disableVerifyOtpButton = false;
      this.userValidation.otpVerificationFailed = true;
    })
  	
  }

  closeCart(){
    let url = window.location.href.split("#")[0];
    history.replaceState({cart : false}, 'cart', url);
    this.appservice.closeCart();
    // console.log(history.length);
    // if(history.length == 2){
    //   console.log("history length is 2");
    //   window.location.href = window.location.href.split("#")[0];
    // }
    // else{
    //   console.log("history length is not 2");
    //   history.back();
    // }
    // this.cart = null;
    // window.location.back();
    // this.cartOpen = false;
    // this.appservice.closeCart();
  }

  modalHandler(){
    console.log("modalHandler")
    if(this.isLoggedInUser()){
      this.navigateToShippingDetailsPage();
    }
    else{
      let url = window.location.href +'/user-verification';
      if(!window.location.href.endsWith('#bag/user-verification'))
        history.pushState({cart : true}, 'cart', url);
      $('#signin').modal('show');
      $("#cd-cart").css("overflow", "hidden");
      $('.modal-backdrop').appendTo('#cd-cart');
      $('body').addClass('hide-scroll');
    }      
  }

  next(event: KeyboardEvent,el1,el2) {
    if(event.key=="Backspace")
      el1.focus();
    else
      el2.focus();
  }

  check_OTP(){
    if(this.otpCode.otp1=='' || this.otpCode.otp2=='' || this.otpCode.otp3=='' || this.otpCode.otp4=='' || this.otpCode.otp5=='' || this.otpCode.otp6=='')
      return true;
  }

  updateOtpModal(updateHistory : boolean = true){
    $('#signin').modal('hide');
    $("#cd-cart").css("overflow", "auto");
    this.mobileNumberEntered = false;
    this.otp = null;
    this.userValidation.otpVerificationErrorMsg = '';
    if(updateHistory){
      let url = window.location.href.split("#")[0];
      history.replaceState({cart : false}, 'cart', url);
    }
  }

  navigateToShippingDetailsPage(){
    if(this.cart.cart_type == "cart"){
      this.appservice.showLoader();
      let url = this.appservice.apiUrl + "/api/rest/v1/user/address/all";
      console.log(this.isLoggedInUser());
      let header = this.isLoggedInUser() ? { Authorization : 'Bearer '+this.appservice.getCookie('token') } : {};
      this.apiservice.request(url, 'get', {} , header ).then((response)=>{
        console.log("response ==>", response);
        this.appservice.shippingAddresses = response.addresses;
        $("#cd-cart").css("overflow", "auto");
        $('.modal-backdrop').remove();
        this.router.navigateByUrl('/shipping-details', { skipLocationChange: true });
        this.appservice.removeLoader();
      })
      .catch((error)=>{
        console.log("error ===>", error);
        this.appservice.removeLoader();
      })
    }
    else{
      this.router.navigateByUrl('/shipping-summary', { skipLocationChange: true });
      this.appservice.continueOrder = true;
    }
  }

  checkCartItemOutOfStock(){
    this.cartItemOutOfStock = false;
    this.cart.items.forEach((item)=>{
      if(!item.availability){
        this.cartItemOutOfStock = true;
        // break;
      }
    })
  }

  editBag(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + '/api/rest/v1/user/cart/start-fresh';
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    this.apiservice.request(url, 'get', {} , header ).then((response)=>{
      console.log("response ==>", response);
      document.cookie='cart_id=' + response.cart_id + ";path=/";
      this.fetchCartDataFromServer();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
    })
  }

  reloadPage(){
    window.location.reload();
  }

  getNewCartId(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + '/api/rest/v1/user/cart/mine';
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    this.apiservice.request(url, 'get', {} , header ).then((response)=>{
      console.log("response ==>", response);
      if(response.cart_id != this.appservice.getCookie('cart_id')){
        document.cookie='cart_id=' + response.cart_id + ";path=/";
        this.fetchCartDataFromServer();
      }
      else{
        this.cart = {};
        this.fetchCartFailed = true;
      }
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
    })
  }
  
}
