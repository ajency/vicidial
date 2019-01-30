import { Component, OnInit, NgZone, Input } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import { Subscription } from 'rxjs/Subscription';

import { PromotionsListComponent } from '../../shared-components/promotions/promotions-list/promotions-list.component';
import { AppliedCouponComponent } from '../../components/applied-coupon/applied-coupon.component';
import { UpgradeCartComponent } from '../../components/upgrade-cart/upgrade-cart.component';
import { BetterPromoAvailableComponent } from '../../components/better-promo-available/better-promo-available.component';
import { BagSummaryComponent } from '../../shared-components/bag-summary/bag-summary/bag-summary.component';

declare var $: any;
declare var add_to_cart_failed: any;
declare var add_to_cart_failure_message: any;
declare var add_to_cart_clicked: any;
declare var add_to_cart_completed: any;
declare var fbTrackInitiateCheckout : any;
declare var google_pixel_tracking : any;
// declare var fbTrackuserRegistration : any;

@Component({
  selector: 'app-bag-view',
  templateUrl: './bag-view.component.html',
  styleUrls: ['./bag-view.component.css']
})
export class BagViewComponent implements OnInit {

  enterCoupon = false;
  cart : any = {};
  sessionCheckInterval : any;
  cartOpen = false;
  reloadSubscription: Subscription;
  loadSubscription: Subscription;
  cartItemOutOfStock : boolean = false;
  fetchCartFailed : boolean = false;
  isCartTypeFailure : boolean = false;
  addToCartFailureMessage = '';
  addToCartFailed : boolean = false;
  promotions = [];
  displayPromo : boolean = true;
  showLoginPopup : boolean = true;
  loginSucessListener : Subscription;
  coupons : any;
  couponCodeListener : any;
  couponCode : any;
  couponErrorMessage : any;
  constructor( private router: Router,
               private appservice : AppServiceService,
               private apiservice : ApiServiceService,
               private zone : NgZone               
              ) { 
    this.reloadSubscription = this.appservice.listenToAddToCartEvent().subscribe(()=> { this.reloadCart() });
    this.loadSubscription = this.appservice.listenToOpenCartEvent().subscribe(()=> { this.loadCart() });

    this.loginSucessListener = this.appservice.listenToLoginSuccess().subscribe(()=>{ this.loginSuccess() });
    this.couponCodeListener = this.appservice.listenToCouponCodeChange().subscribe((data)=>{ this.couponSelected(data) })
  }

  reloadCart(){
    console.log("listened to the add to cart trigger");
    this.cartOpen = true;
    add_to_cart_clicked = false;
    this.fetchCartDataOnAddToCartSuccess();
  }

  loadCart(){
    console.log("listened to open cart trigger");
    this.cartOpen = true;    
    this.getCartData();
  }

  ngOnDestroy() {
    console.log("bag-view ngOnDestroy");
    this.reloadSubscription.unsubscribe();
    this.loadSubscription.unsubscribe();
    this.loginSucessListener.unsubscribe();
    this.couponCodeListener.unsubscribe();
  }

  ngOnInit() {
    console.log("ngOnInit cart component", add_to_cart_clicked);        
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
    this.appservice.showLoader();
    this.addToCartFailureMessage = '';
    this.addToCartFailed = false;    
    this.appservice.callFetchCartApi().then((response)=>{
      console.log("promotions ==>", response.promotions); 
      this.fetchCartSuccessHandler(response);                 
      this.zone.run(() => {});
    })
    .catch((error)=>{
      this.checkAddToCartStatus();
      this.handleFetchCartFailure(error);
      this.appservice.removeLoader();
      this.zone.run(() => {});
    })
    this.zone.run(() => {});
  }


  fetchCartSuccessHandler(response){
    this.cart = this.formattedCartDataForUI(response);
    console.log("this.cart ==>", this.cart);
    // this.formatPromotions(response);
    // this.setCoupons();
    this.formatCoupons(response.coupons);
    this.checkCartItemOutOfStock();
    this.appservice.removeLoader();
    // this.checkAppliedPromotionValidity();
    this.updateLocalDataAndUI(this.cart, this.cart.cart_count);
    console.log(add_to_cart_failed);
    this.checkAddToCartStatus();     
    if(this.cart.cart_type == 'failure'){
      this.editBag();
      this.isCartTypeFailure = true;
    }
    this.fetchCartFailed = false;  
    console.log(this.google_track_response(response));
    let result = this.google_track_response(response); 
    google_pixel_tracking(result.pixel_ids, result.total_values, "cart");
    this.zone.run(() => {});    
  }

  google_track_response(response){
    let pixel_ids = [], total_values = [];
    response.items.forEach((item)=>{
      pixel_ids.push(item.pixel_id);
      total_values.push(item.attributes.price_final);
    })
    // console.log("check ==>", variant_ids, total_values);
    let result = {
      pixel_ids : pixel_ids.join(),
      total_values : total_values.join()
    }
    return result;  
  }

  checkAddToCartStatus(){
    if(add_to_cart_failed){
      console.log("add_to_cart_failed", add_to_cart_failure_message);
      this.addToCartFailureMessage = add_to_cart_failure_message;
      this.addToCartFailed = true;
      add_to_cart_failed = false;
      add_to_cart_failure_message = '';
    }
    this.zone.run(() => {});  
  }

  formattedCartDataForUI(data){
    data.items.forEach((item)=>{
      if(item.attributes.price_mrp != item.attributes.price_final)
        item.off_percentage = Math.round(((item.attributes.price_mrp - item.attributes.price_final) / (item.attributes.price_mrp )) * 100) + '% OFF';
      item.href = '/' + item.product_slug +'/buy?size='+item.attributes.size;
      item.attributes.images = Array.isArray(item.attributes.images) ? ['/img/placeholder.svg', '/img/placeholder.svg', '/img/placeholder.svg'] : Object.values(item.attributes.images);
    })

    data.items.sort((a,b)=>{ return b.timestamp - a.timestamp});
    // data.items.reverse();
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
    this.appservice.showLoader();
    let body = { variant_id : item.id };
    let url = this.appservice.apiUrl + (this.appservice.isLoggedInUser() ? ("/api/rest/v1/user/cart/"+this.appservice.getCookie('cart_id')+"/delete?") : ("/rest/v1/anonymous/cart/delete?"));
    let header = this.appservice.isLoggedInUser() ? { Authorization : 'Bearer '+this.appservice.getCookie('token') } : {};
    url = url+$.param(body);
    this.apiservice.request(url, 'get', body, header ).then((response)=>{
      let index = this.cart.items.findIndex(i => i.id == item.id)
      this.cart.items.splice(index,1);
      this.cart.summary = response.summary;
      this.cart.applied_coupon = response.applied_coupon;
      this.formatCoupons(response.coupons);     
      this.cart.cart_count = response.cart_count;
      this.checkCartItemOutOfStock();
      this.updateLocalDataAndUI(this.cart, this.cart.cart_count);
      this.appservice.removeLoader();
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
    this.appservice.closeCart();
    if(document.getElementById('cd-coupon')){
      document.getElementById('cd-coupon').classList.remove('slide-show');
      document.querySelector('.coupon-sticky').classList.remove('fixed-bottom');
      this.enterCoupon = false;
    }
  }

  viewOrders(){
      this.router.navigateByUrl('account/my-orders');
  }

  checkLoginStatus(){
    console.log(this.google_track_response(this.cart));
    let result = this.google_track_response(this.cart); 
    google_pixel_tracking(result.pixel_ids, result.total_values, "checkout");
    fbTrackInitiateCheckout(this.cart.summary.you_pay);
    this.addToCartFailed = false;
    if(this.appservice.isLoggedInUser()){
      this.navigateToShippingDetailsPage();
    }
    else{
      this.callCheckCartStatusApi();
    }      
  }

  displayModal(){
    this.router.navigate([{ outlets: { popup: ['user-login'] }}]);
  }


  removeModal(updateHistory : boolean = true){
    this.showLoginPopup = false;
    $('#signin').modal('hide');
    $("#cd-cart").css("overflow", "auto");
  }

  navigateToShippingDetailsPage(){
    this.removeModal();
    console.log("navigateToShippingDetailsPage");
    if(this.cart.cart_type == "cart"){
      this.appservice.showLoader();
      this.appservice.callGetAllAddressesApi(true).then((response)=>{
        this.appservice.shippingAddresses = response.addresses;
        this.appservice.userMobile = response.user_info.mobile;
        $("#cd-cart").css("overflow", "auto");
        $('.modal-backdrop').remove();

        this.appservice.navigatingFromBagToAddress = true;
        if(this.appservice.userVerificationComplete){
          this.appservice.userVerificationComplete = false;
          this.router.navigateByUrl('bag/shipping-address', { replaceUrl: true });
        }
        else
          this.router.navigateByUrl('bag/shipping-address');
        this.appservice.removeLoader();
      })
      .catch((error)=>{
        console.log("error ===>", error);
        this.appservice.removeLoader();
        this.fetchCartDataFromServer();
      })
    }
    else{
      this.router.navigateByUrl('bag/shipping-summary');
      // this.router.navigate(['shipping-summary']);
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
    else if((error.status == 400 || error.status == 403)){
      if(this.appservice.isLoggedInUser()){
        this.getNewCartId();
        this.fetchCartFailed = false; 
      }
      else{
        this.fetchCartDataFromServer();
      }        
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

  formatPromotions(response){
    console.log(response);
    let promos = Object.keys(response.promotions).map((k)=>{ return response.promotions[k] });
    console.log("promos ==>",promos);
    try{
      promos.forEach((promo)=>{ 
        promo.actual_discount = this.appservice.calculateDiscount(promo.discount_type, promo.discount_value, this.cart.summary.sale_price_total);
        console.log(promo.actual_discount);
      });
    }
    catch(e){
      console.log("error ==>",e);
    }
    this.promotions = promos;
  }

  checkAppliedPromotionValidity(){
    if(this.cart.promo_applied && this.cart.cart_type == 'order'){
      let applied_promo = this.promotions.find((promotion)=>{ return this.cart.promo_applied == promotion.promotion_id});
      console.log("checkAppliedPromotionValidity ==>",applied_promo)
      if(!applied_promo){
        this.editBag();
      }
    }
  }

  loginSuccess(){
    console.warn("loginSuccess navigateToShippingDetailsPage")
    this.navigateToShippingDetailsPage();
  }

  formatCoupons(coupons){
    this.coupons = coupons;
  }

  applyCoupon(){
    console.log("inside applyCoupon function", this.couponCode);
    this.appservice.showLoader();
    let body = { coupon_code : this.couponCode };
    let url = this.appservice.apiUrl + (this.appservice.isLoggedInUser() ? ("/api/rest/v1/user/cart/"+this.appservice.getCookie('cart_id')+"/apply-coupon?") : ("/rest/v1/anonymous/cart/apply-coupon?"));
    let header = this.appservice.isLoggedInUser() ? { Authorization : 'Bearer '+this.appservice.getCookie('token') } : {};
    url = url+$.param(body);
    this.apiservice.request(url, 'get', body, header ).then((response)=>{
      this.cart.summary = response.summary;
      this.cart.applied_coupon = response.coupon_applied;
      // this.displayPromo = true;
      this.enterCoupon = false;
      this.appservice.removeLoader();
      this.couponErrorMessage = '';
    })
    .catch((error)=>{
      console.log("error ===>", error);
      if(error.status == 401){
        this.appservice.userLogout();
        this.enterCoupon = false;
        this.fetchCartDataFromServer();
        this.fetchCartFailed = false; 
      }
      else{
        if(error.status == 0){
          this.couponErrorMessage = "No Internet Connection";  
        }
        else{
          this.couponErrorMessage = error.message;
        }        
        this.appservice.removeLoader();
      }
      // else if(error.status == 403 && this.appservice.isLoggedInUser() ){
      //   this.enterCoupon = false;
      //   this.getNewCartId();
      //   this.fetchCartFailed = false; 
      // }      
    })    
  }

  couponSelected(code){
    console.log("couponSelected function", code);
    this.couponCode = code;
  }

  hideCouponSideBar(){
    this.enterCoupon = false;
    this.couponErrorMessage = '';
  }
  
}
