import { Component, OnInit, NgZone, Input } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import { Subscription } from 'rxjs';

import { PromotionsListComponent } from '../../shared-components/promotions/promotions-list/promotions-list.component';
import { AppliedCouponComponent } from '../components/applied-coupon/applied-coupon.component';
import { UpgradeCartComponent } from '../components/upgrade-cart/upgrade-cart.component';
import { BetterPromoAvailableComponent } from '../components/better-promo-available/better-promo-available.component';
import { BagSummaryComponent } from '../../shared-components/bag-summary/bag-summary/bag-summary.component';

declare var $: any;

declare var fbTrackInitiateCheckout : any;
declare var google_pixel_tracking : any;

@Component({
  selector: 'app-bag-view',
  templateUrl: './bag-view.component.html',
  styleUrls: ['./bag-view.component.scss']
})
export class BagViewComponent implements OnInit {

  enterCoupon = false;
  cart : any = {};
  sessionCheckInterval : any;
  cartOpenOnTrigger = false;
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
  openShippingAddress : boolean = false;
  openShippingSummary : boolean = false;
  updateViewListner : Subscription;
  selectedQuantity : any;
  totalQuantity : any;
  itemIndex : any;
  updateQuantityFailed : any;
  updateQuantityFailureMsg : any;
  cdnUrl : any;
  constructor( private router: Router,
               private appservice : AppServiceService,
               private apiservice : ApiServiceService,
               private zone : NgZone
              ) {
    this.cdnUrl = this.appservice.cdnUrl;
    this.reloadSubscription = this.appservice.listenToAddToCartEvent().subscribe(()=> { this.reloadCart() });
    this.loadSubscription = this.appservice.listenToOpenCartEvent().subscribe(()=> { this.loadCart() });

    this.loginSucessListener = this.appservice.listenToLoginSuccess().subscribe(()=>{ this.loginSuccess() });
    this.couponCodeListener = this.appservice.listenToCouponCodeChange().subscribe((data)=>{ this.couponSelected(data) })

    this.updateViewListner = this.appservice.listenToUpdateCartViewTrigger().subscribe(()=>{ this.updateView() })
  }

  reloadCart(){
    console.log("listened to the add to cart trigger");
    this.cartOpenOnTrigger = true;
    this.appservice.add_to_cart_clicked = false;
    this.fetchCartDataOnAddToCartSuccess();
    this.openShippingAddress = false;
    this.openShippingSummary = false;
  }

  loadCart(){
    console.log("listened to open cart trigger");
    this.cartOpenOnTrigger = true;
    this.getCartData();
    this.openShippingAddress = false;
    this.openShippingSummary = false;
  }

  ngOnDestroy() {
    console.log("bag-view ngOnDestroy");
    this.reloadSubscription.unsubscribe();
    this.loadSubscription.unsubscribe();
    this.loginSucessListener.unsubscribe();
    this.couponCodeListener.unsubscribe();
    this.updateViewListner.unsubscribe();
  }

  ngOnInit() {
    console.log("ngOnInit cart component", this.appservice.add_to_cart_clicked);
    // this.cartOpenOnTrigger = true;
    $('.ng-cart-loader').removeClass('cart-loader')
    if(this.appservice.add_to_cart_clicked){
      this.fetchCartDataOnAddToCartSuccess();
      this.appservice.add_to_cart_clicked = false;
    }
    else{
      this.getCartData();
    }
    this.updateUrl();
  }

  fetchCartDataOnAddToCartSuccess(){
    this.appservice.showLoader();
    if(sessionStorage.getItem('cart_data')){
      this.cart = JSON.parse(sessionStorage.getItem('cart_data'));
    }
    else
      this.cart = {};

    this.sessionCheckInterval = setInterval(()=>{
      if(this.appservice.add_to_cart_completed){
        this.fetchCartDataFromServer();
        this.appservice.add_to_cart_completed = false;
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
    this.updateQuantityFailed = false;
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
    console.log(this.appservice.add_to_cart_failed);
    this.checkAddToCartStatus();
    if(this.cart.cart_type == 'failure'){
      this.editBag();
      this.isCartTypeFailure = true;
    }
    this.fetchCartFailed = false;
    let result = this.google_track_response(response);
    google_pixel_tracking(result.pixel_ids, result.total_values, "cart");
    this.zone.run(() => {});
  }

  google_track_response(response){
    let result = { pixel_ids : [], total_values : [] };
    response.items.forEach((item)=>{
      result.pixel_ids.push(item.pixel_id);
      result.total_values.push(item.attributes.price_final);
    })
    console.log("check ==>", result);
    return result;
  }

  checkAddToCartStatus(){
    if(this.appservice.add_to_cart_failed){
      console.log("this.appservice.add_to_cart_failed", this.appservice.add_to_cart_failure_message);
      this.addToCartFailureMessage = this.appservice.add_to_cart_failure_message;
      this.addToCartFailed = true;
      this.appservice.add_to_cart_failed = false;
      this.appservice.add_to_cart_failure_message = '';
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

  modifyCart(quantity){
    this.addToCartFailed = false;
    this.updateQuantityFailed = false;
    this.appservice.showLoader();
    console.log("inside modifyCart function ==>", quantity, this.itemIndex);
    let item = this.cart.items[this.itemIndex];
    let url = this.appservice.apiUrl + (this.appservice.isLoggedInUser() ? ("/api/rest/v2/user/cart/"+this.appservice.getCookie('cart_id')+"/update") : ("/rest/v2/anonymous/cart/update"));
    let body = {
    //   old_item : item.id,
    //   new_item : item.related_items.size.find(size=> size.value == item.attributes.size).id,
      variant_id : item.id,
      variant_quantity : quantity
    }
    let header = this.appservice.isLoggedInUser() ? { Authorization : 'Bearer '+this.appservice.getCookie('token') } : {};
    this.apiservice.request(url, 'post', body, header).then((response)=>{
      console.log("response ==>", response);
      item = response.item;
      if(item.attributes.price_mrp != item.attributes.price_final)
        item.off_percentage = Math.round(((item.attributes.price_mrp - item.attributes.price_final) / (item.attributes.price_mrp )) * 100) + '% OFF';
      item.href = '/' + item.product_slug +'/buy?size='+item.attributes.size;
      item.attributes.images = Array.isArray(item.attributes.images) ? ['/img/placeholder.svg', '/img/placeholder.svg', '/img/placeholder.svg'] : Object.values(item.attributes.images);

      this.cart.items[this.itemIndex] = item;

      this.cart.summary = response.summary;
      this.cart.coupon_applied = response.coupon_applied;
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
      else{
        this.updateQuantityFailed = true;
        this.updateQuantityFailureMsg = error.error.message;
      }
      this.appservice.removeLoader();
    })
  }

  deleteItem(item){
    this.addToCartFailed = false;
    this.updateQuantityFailed = false;
    this.appservice.showLoader();
    let body = { variant_id : item.id };
    let url = this.appservice.apiUrl + (this.appservice.isLoggedInUser() ? ("/api/rest/v2/user/cart/"+this.appservice.getCookie('cart_id')+"/delete?") : ("/rest/v2/anonymous/cart/delete?"));
    let header = this.appservice.isLoggedInUser() ? { Authorization : 'Bearer '+this.appservice.getCookie('token') } : {};
    url = url+$.param(body);
    this.apiservice.request(url, 'get', body, header ).then((response)=>{
      let index = this.cart.items.findIndex(i => i.id == item.id)
      this.cart.items.splice(index,1);
      this.cart.summary = response.summary;
      this.cart.coupon_applied = response.coupon_applied;
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
    this.hideCouponSideBar();
  }

  viewOrders(){
      // this.router.navigateByUrl('account/my-orders');
      this.appservice.loadAccountFromAngular = true;
      let url = window.location.href.split("#")[0] + '#/account/my-orders';
      history.pushState({bag : true}, 'account', url);
      this.appservice.loadCartTrigger();
  }

  checkLoginStatus(){
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
    console.log("displayModal function")
    this.appservice.displaySkipOTP = true;
    // this.router.navigate([{ outlets: { popup: ['user-login'] }}]);
    this.appservice.showLoginPopupTrigger();
  }


  removeModal(updateHistory : boolean = true){
    this.showLoginPopup = false;
    // $('#signin').modal('hide'); //uncomment this line once bootstrap modal is added
    $("#cd-cart").css("overflow", "auto");
  }

  navigateToShippingDetailsPage(){
    this.removeModal();
    console.log("navigateToShippingDetailsPage");
    if(this.cart.cart_type == "cart"){
      this.appservice.showLoader();
      this.appservice.callGetAllAddressesApi(true).then((response)=>{
        if(response.get_user_info){
          this.appservice.hideAddressUser = false;
        } else {
          this.appservice.hideAddressUser = true;
        }
        this.appservice.shippingAddresses = response.addresses;
        this.appservice.userMobile = response.user_info.mobile;
        $("#cd-cart").css("overflow", "auto");
        $('.modal-backdrop').remove();

        this.appservice.navigatingFromBagToAddress = true;
        if(this.appservice.userVerificationComplete){
          this.appservice.userVerificationComplete = false;
          // this.router.navigateByUrl('bag/shipping-address', { replaceUrl: true });
          let url = window.location.href.split("#")[0] + '#/bag/shipping-address';
          history.pushState({bag : true}, 'bag', url);
          this.openShippingAddress = true;
          $('#cd-cart').addClass('overflow-h');
        }
        else{
          // this.router.navigateByUrl('bag/shipping-address');
          let url = window.location.href.split("#")[0] + '#/bag/shipping-address';
          history.pushState({bag : true}, 'bag', url);
          this.openShippingAddress = true;
          $('#cd-cart').addClass('overflow-h');
        }
        this.appservice.removeLoader();
      })
      .catch((error)=>{
        console.log("error ===>", error);
        this.appservice.removeLoader();
        this.fetchCartDataFromServer();
      })
    }
    else{
      this.continueOrder();
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
    let url = this.appservice.apiUrl + '/api/rest/v2/user/cart/start-fresh';
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    this.apiservice.request(url, 'get', {} , header ).then((response)=>{
      document.cookie='cart_id=' + response.cart_id + ";path=/";
      this.fetchCartDataFromServer();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      if(error.status == 401){
        this.appservice.userLogout();
        this.fetchCartDataFromServer();
      }
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
    if(this.appservice.isSessionStorageSupported()){
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
    let url = this.appservice.apiUrl + '/rest/v2/anonymous/cart/check-status';
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
    if(window.location.hash.startsWith('#/bag')){
      console.warn("loginSuccess navigateToShippingDetailsPage")
      this.navigateToShippingDetailsPage();
    }
  }

  formatCoupons(coupons){
    this.coupons = coupons;
  }

  applyCoupon(code){
    this.appservice.showLoader();
    let body = { coupon_code : code };
    let url = this.appservice.apiUrl + (this.appservice.isLoggedInUser() ? ("/api/rest/v2/user/cart/"+this.appservice.getCookie('cart_id')+"/apply-coupon") : ("/rest/v2/anonymous/cart/apply-coupon"));
    let header = this.appservice.isLoggedInUser() ? { Authorization : 'Bearer '+this.appservice.getCookie('token') } : {};
    this.apiservice.request(url, 'get', body, header ).then((response)=>{
      this.cart.summary = response.summary;
      this.cart.coupon_applied = response.coupon_applied;
      this.hideCouponSideBar()
      this.appservice.removeLoader();
      this.couponErrorMessage = '';
    })
    .catch((error)=>{
      console.log("error ===>", error);
      if(error.status == 401){
        this.appservice.userLogout();
        this.hideCouponSideBar();
        this.fetchCartDataFromServer();
        this.fetchCartFailed = false;
      }
      else{
        if(error.status == 0){
          this.couponErrorMessage = "No Internet Connection";
        }
        else{
          this.couponErrorMessage = error.error.message;
        }
        this.appservice.removeLoader();
      }
      // else if(error.status == 403 && this.appservice.isLoggedInUser() ){
      //   this.hideCouponSideBar();
      //   this.getNewCartId();
      //   this.fetchCartFailed = false;
      // }
    })
  }

  couponSelected(code){
    console.log("couponSelected function", code);
    // this.couponCode = code;
    this.applyCoupon(code); 
  }

  hideCouponSideBar(){
    this.couponCode = '';
    this.enterCoupon = false;
    this.couponErrorMessage = '';
    $('#cd-cart').removeClass('overflow-h');
  }

  displayCouponSideBar(){
    if(this.cart.cart_type == "cart"){
      this.enterCoupon = true;
      $('#cd-cart').addClass('overflow-h');
    }
  }

  updateUrl(){
    let url = window.location.href.split("#")[0] + '#/bag';
    history.replaceState({bag : true}, 'bag', url);
  }

  updateView(){
    console.log("update view data ==>");
    if(window.location.href.includes('#/bag')){
      this.openShippingAddress = false;
      this.openShippingSummary = false;
      if(this.cartOpenOnTrigger)
        this.cartOpenOnTrigger = false;
      else{
        if(this.appservice.add_to_cart_clicked){
          this.fetchCartDataOnAddToCartSuccess();
          this.appservice.add_to_cart_clicked = false;
        }
        else
          this.fetchCartDataFromServer();
      }
      $('#cd-cart').removeClass('overflow-h');

      this.updateUrl();
    }
    // else if(window.location.href.endsWith('#/bag/shipping-address')){
    //   this.openShippingSummary = false;
    //   $('#cd-cart').addClass('overflow-h');
    // }
  }

  updateQuantity(item, index){
    console.log("updateQuantity ==>", item, index);
    this.selectedQuantity = item.quantity;
    this.totalQuantity = 5;
    if(item.available_quantity < 5)
      this.totalQuantity = item.available_quantity;
    this.itemIndex = index;
    $('#qty-modal-cart').modal('show');
    $("#cd-cart").css("overflow-y", "hidden");
    $('.modal-backdrop').appendTo('.angular-app');

    $('#qty-modal-cart').on('hidden.bs.modal', function (e) {
      $("#cd-cart").css("overflow-y", "auto");
    })
  }

  continueOrder(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + '/api/rest/v2/user/cart/' + this.appservice.getCookie('cart_id') + '/continue-order';
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    
    this.apiservice.request(url, 'post', {} , header ).then((response)=>{
      this.appservice.shippingDetails = response;
      let url = window.location.href.split("#")[0] + '#/bag/shipping-summary';
      history.pushState({bag : true}, 'bag', url);
      this.openShippingSummary = true;
      $('#cd-cart').addClass('overflow-h');
      this.appservice.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
      if(error.status == 403){
        this.editBag();
      }
      else if(error.status == 401){
        this.appservice.userLogout();
        this.fetchCartDataFromServer();
      }
    })  
  }

}
