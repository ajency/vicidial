import { Component, OnInit, NgZone } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import { Subscription } from 'rxjs/Subscription';

import { LoginComponentComponent } from '../../shared-components/login/login-component/login-component.component';
import { PromotionsListComponent } from '../../shared-components/promotions/promotions-list/promotions-list.component';

// import * as $ from 'jquery';
declare var $: any;
declare var add_to_cart_failed: any;
declare var add_to_cart_failure_message: any;
declare var add_to_cart_clicked: any;
declare var add_to_cart_completed: any;

// declare var fbTrackuserRegistration : any;
@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.css']
})
export class CartComponent implements OnInit {

  enterCoupon = false;
  cart : any = {};
  sessionCheckInterval : any;
  cartOpen = false;
  reloadSubscription: Subscription;
  loadSubscription: Subscription;
  closeModalSubscription: Subscription;
  openModalSubscription : Subscription;
  cartItemOutOfStock : boolean = false;
  fetchCartFailed : boolean = false;
  isCartTypeFailure : boolean = false;
  addToCartFailureMessage = '';
  addToCartFailed : boolean = false;
  promotions = [];
  constructor( private router: Router,
               private appservice : AppServiceService,
               private apiservice : ApiServiceService,
               private zone : NgZone
              ) { 
    // this.createDummyPromotions();
    this.reloadSubscription = this.appservice.listenToAddToCartEvent().subscribe(()=> { this.reloadCart() });
    this.loadSubscription = this.appservice.listenToOpenCartEvent().subscribe(()=> { this.loadCart() });

    this.closeModalSubscription = this.appservice.listenToCloseModal().subscribe(()=>{ this.updateOtpModal(false)});
    this.openModalSubscription = this.appservice.listenToOpenModal().subscribe(()=>{ this.modalHandler()});

  }

  reloadCart(){
    this.updateUrl();
    console.log("listened to the add to cart trigger");
    this.cartOpen = true;
    this.fetchCartDataOnAddToCartSuccess();
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
    this.loadSubscription.unsubscribe();
    this.closeModalSubscription.unsubscribe();
    this.openModalSubscription.unsubscribe();
  }

  ngOnInit() {
    console.log("ngOnInit cart component");        
      this.updateUrl();
      this.cartOpen = true;
      $('.ng-cart-loader').removeClass('cart-loader')
      if(add_to_cart_clicked){
        this.fetchCartDataOnAddToCartSuccess();
        add_to_cart_clicked = false;
      }
      else{
        this.getCartData();
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
    this.appservice.showLoader();
    if(sessionStorage.getItem('cart_data')){
      this.cart = JSON.parse(sessionStorage.getItem('cart_data'));
    }
    else
      this.cart = {};
    
    this.sessionCheckInterval = setInterval(()=>{
      if(add_to_cart_completed){
        this.fetchCartDataFromServer();
        add_to_cart_completed = false;
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
    }
    this.fetchCartDataFromServer();
  }

  fetchCartDataFromServer(){
    this.addToCartFailureMessage = '';
    this.addToCartFailed = false;
    this.appservice.showLoader()
    this.appservice.callFetchCartApi().then((response)=>{
      this.promotions = Object.keys(response.promotions).map((k)=>{ return response.promotions[k] });
      this.cart = this.formattedCartDataForUI(response);      
      console.log("promotions ==>", response.promotions);  
      this.checkCartItemOutOfStock();
      this.updateLocalDataAndUI(this.cart, this.cart.cart_count);
      console.log(add_to_cart_failed);
      if(add_to_cart_failed){
        console.log("add_to_cart_failed", add_to_cart_failure_message);
        this.addToCartFailureMessage = add_to_cart_failure_message;
        this.addToCartFailed = true;
        add_to_cart_failed = false;
        add_to_cart_failure_message = '';
      }
      this.appservice.removeLoader();
      if(this.cart.cart_type == 'failure'){
        this.editBag();
        this.isCartTypeFailure = true;
      }
      this.fetchCartFailed = false;
      this.zone.run(() => {});
    })
    .catch((error)=>{
      if(add_to_cart_failed){
        console.log("add_to_cart_failed", add_to_cart_failure_message);
        add_to_cart_failed = false;
        add_to_cart_failure_message = '';
      }
      this.handleFetchCartFailure(error);
      this.appservice.removeLoader();
      this.zone.run(() => {});
    })
    this.zone.run(() => {});
  }

  formattedCartDataForUI(data){
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
    this.addToCartFailed = false;
    this.appservice.showLoader()
    let body = { variant_id : item.id };
    let url = this.appservice.apiUrl + (this.appservice.isLoggedInUser() ? ("/api/rest/v1/user/cart/"+this.appservice.getCookie('cart_id')+"/delete?") : ("/rest/v1/anonymous/cart/delete?"));
    let header = this.appservice.isLoggedInUser() ? { Authorization : 'Bearer '+this.appservice.getCookie('token') } : {};
    url = url+$.param(body);
    this.apiservice.request(url, 'get', body, header ).then((response)=>{
      let index = this.cart.items.findIndex(i => i.id == item.id)
      this.cart.items.splice(index,1);
      this.cart.summary = response.summary;
      this.cart.cart_count = response.cart_count;
      this.checkCartItemOutOfStock();
      this.updateLocalDataAndUI(this.cart, this.cart.cart_count);
      this.appservice.removeLoader()
    })
    .catch((error)=>{
      console.log("error ===>", error);
      if(error.status == 401){
        this.appservice.userLogout();
        this.fetchCartDataFromServer();
        this.fetchCartFailed = false; 
      }
      else if((error.status == 400 || error.status == 403) && this.appservice.isLoggedInUser() ){
        this.getNewCartId();
        this.fetchCartFailed = false; 
      }
      this.appservice.removeLoader();
    })
  }

  closeCart(){
    let url = window.location.href.split("#")[0];
    history.pushState({cart : false}, 'cart', url);
    this.reloadPage();
    this.appservice.closeCart();
  }

  viewOrders(){
      let url = window.location.href.split("#")[0] + '#/account/my-orders';
      this.appservice.closeCart();
      history.pushState({cart : false}, 'cart', url);
      // window.location.href = url;
      this.reloadPage();
  }

  modalHandler(){
    this.addToCartFailed = false;
    if(this.appservice.isLoggedInUser()){
      this.navigateToShippingDetailsPage();
    }
    else{
      this.callCheckCartStatusApi();
    }      
  }

  displayModal(){
    let url = window.location.href +'/user-verification';
    if(!window.location.href.endsWith('#bag/user-verification'))
      history.pushState({cart : true}, 'cart', url);
    $('#signin').modal('show');
    $("#cd-cart").css("overflow", "hidden");
    $('.modal-backdrop').appendTo('#cd-cart');
    $('body').addClass('hide-scroll');
  }


  updateOtpModal(updateHistory : boolean = true){
    $('#signin').modal('hide');
    $("#cd-cart").css("overflow", "auto");
    // this.mobileNumberEntered = false;
    // this.otp = null;
    // this.otpCode.otp1 =''; this.otpCode.otp2 = ''; this.otpCode.otp3 = ''; this.otpCode.otp4 = ''; this.otpCode.otp5 = ''; this.otpCode.otp6='';
    // this.userValidation.otpVerificationErrorMsg = '';
  }

  navigateToShippingDetailsPage(){
    console.log("navigateToShippingDetailsPage");
    if(this.cart.cart_type == "cart"){
      this.appservice.showLoader();
      this.appservice.callGetAllAddressesApi(true).then((response)=>{
        this.appservice.shippingAddresses = response.addresses;
        $("#cd-cart").css("overflow", "auto");
        $('.modal-backdrop').remove();
        this.router.navigateByUrl('/shipping-details', { skipLocationChange: true });
        this.appservice.removeLoader();
      })
      .catch((error)=>{
        console.log("error ===>", error);
        this.appservice.removeLoader();
        this.fetchCartDataFromServer();
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
    this.appservice.callMineApi().then((response)=>{
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
      console.log("error : mine api===>", error);
      this.appservice.removeLoader();
    })
  }

  shopNow(){
    window.location.href = '/shop'
  }

  updateLocalDataAndUI(cart : any = null, cart_count = 0){
    console.log("isSessionStorageSupported ==>", this.isSessionStorageSupported());
    if(this.isSessionStorageSupported()){
      if(cart)
          sessionStorage.setItem('cart_data', JSON.stringify(cart));
      else
        this.appservice.clearSessionStorage();
    }
    document.cookie = "cart_count=" + cart_count + ";path=/";
    this.appservice.updateCartCountInUI();
  }

  handleFetchCartFailure(error){
    if(error.status == 401){
      this.appservice.userLogout();
      this.fetchCartDataFromServer();
      this.fetchCartFailed = false; 
    }
    else if((error.status == 400 || error.status == 403) && this.appservice.isLoggedInUser() ){
      this.getNewCartId();
      this.fetchCartFailed = false; 
    }
    else if(error.status == 404){
      this.cart = {
        items : []
      }
      this.fetchCartFailed = false;
      this.updateLocalDataAndUI();
    }
    else{
      this.cart = {};
      this.fetchCartFailed = true;
      this.updateLocalDataAndUI();
    }
  }

  callCheckCartStatusApi(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + '/rest/v1/anonymous/cart/check-status';
    this.apiservice.request(url, 'get', {} , {} ).then((response)=>{
      this.appservice.removeLoader();
      this.displayModal();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
      this.fetchCartDataFromServer()
    })
  }

  isSessionStorageSupported() {
    try {
      sessionStorage.setItem('test', 'test');
      sessionStorage.removeItem('test');    
      return true;
    } catch (e) {
      return false;
    }
  }

  createDummyPromotions(){
    this.promotions = [
      {
        promotion_id: 123,
        display_title: "Buy 2000 Get 250 Off",
        description: "something something",
        min_cart_value: 2000,
        discount_value: 250,
        discount_type: "value",
        valid_from: "2018-10-12 10:30:00",
        valid_till: "11/08/2018 00:00:00"
    },
    {
        promotion_id: 123,
        display_title: "Buy 2000 Get 250 Off",
        description: "something something ",
        min_cart_value: 1000,
        discount_value: 10,
        discount_type: "percent",
        valid_from: "2018-10-12 10:30:00",
        valid_till: "11/08/2018 00:00:00"
    },
    {
        promotion_id: 123,
        display_title: "Buy 2000 Get 250 Off",
        description: "something something ",
        min_cart_value: 4000,
        discount_value: 10,
        discount_type: "percent",
        valid_from: "2018-10-12 10:30:00",
        valid_till: "11/08/2018 00:00:00"
    },
    {
        promotion_id: 123,
        display_title: "Buy 2000 Get 250 Off",
        description: "something something ",
        min_cart_value: 3000,
        discount_value: 10,
        discount_type: "percent",
        valid_from: "2018-10-12 10:30:00",
        valid_till: "11/08/2018 00:00:00"
    },
    {
        promotion_id: 124,
        display_title: "Buy 2000 Get 250 Off",
        description: "something something ",
        min_cart_value: 1000,
        discount_value: 10,
        discount_type: "percent",
        valid_from: "2018-10-12 10:30:00",
        valid_till: "11/08/2018 00:00:00"
    }
    ]
  }
  
}
