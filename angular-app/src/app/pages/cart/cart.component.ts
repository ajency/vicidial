import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import * as $ from 'jquery';

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.css']
})
export class CartComponent implements OnInit {

  mobileNumberEntered = false;
  enterCoupon = false;
  cart : any;
  showCartLoader = false;
  sessionCheckInterval : any;
  cartOpen = false;
  mobileNumber : any;
  otp : number;
  userValidation = {
    disableSendOtpButton :  false,
    mobileValidationFailed : false,
    mobileValidationErrorMsg : '',
    disableVerifyOtpButton : false,
    otpVerificationFailed : false,
    otpVerificationErrorMsg : ''
  }
  
  constructor( private router: Router,
               private appservice : AppServiceService,
               private apiservice : ApiServiceService
              ) { 

  }

  ngOnInit() {
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

  ngAfterViewInit(){
    var self = this;
    console.log("ngAfterViewInit");
    $("#cd-cart-trigger").click(function() {
      console.log("calling getCartData function");
      this.cartOpen = true;
      self.getCartData();                       
    });
    $('.cd-add-to-cart').on('click',function(){
      console.log("add to cart clicked");
      this.cartOpen = true;
      self.fetchCartDataOnAddToCartSuccess();
      sessionStorage.removeItem('add_to_cart_clicked');
    });
  }

  fetchCartDataOnAddToCartSuccess(){    
    this.showCartLoader = true;
    if(sessionStorage.getItem('cart_data')){
      this.cart = JSON.parse(sessionStorage.getItem('cart_data'));
      console.log("cart_data from sessionStorage==>", this.cart);
    }
    this.sessionCheckInterval = setInterval(()=>{
      if(sessionStorage.getItem('addded_to_cart')){
        if(sessionStorage.getItem('addded_to_cart') == "true")
          this.fetchCartDataFromServer();
        else
          this.showCartLoader = false;
        sessionStorage.removeItem('addded_to_cart');
        clearInterval(this.sessionCheckInterval);
      }
    },100)
  }

  getCartData(){
    if(sessionStorage.getItem('cart_data')){
      this.cart = JSON.parse(sessionStorage.getItem('cart_data'));
      console.log("cart_data from sessionStorage==>", this.cart);
    }
    else{
      this.fetchCartDataFromServer()
    }
  }

  fetchCartDataFromServer(){
    this.showCartLoader = true;
    let url = this.appservice.apiUrl + '/rest/anonymous/cart/get';
    this.apiservice.request(url, 'get', {} ).then((response)=>{
      console.log("response ==>", response);
      this.cart = response;
      sessionStorage.setItem('cart_data', JSON.stringify(this.cart));
      this.showCartLoader=false;
    })
    .catch((error)=>{
      console.log("error ===>", error);
      if(error.message == "Cart not found for this session"){
        this.cart = {
          items : []
        }
      }
      this.showCartLoader=false;
    })
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
    // let url = 'http://localhost:8000/rest/anonymous/cart/update';
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
    // console.log("delete item ==>", item);
    // let body = {
    //   item_id : item.id
    // }
    // let url = 'http://localhost:8000/rest/anonymous/cart/delete';
    // this.apiservice.request(url, 'get', body ).then((response)=>{
    //   console.log("response ==>", response);
    //   let index = this.cart.items.findIndex(i => i.id == item.id)
    //   this.cart.items.splice(index,1);
    //   sessionStorage.setItem('cart_data', JSON.stringify(this.cart));
    // })
    // .catch((error)=>{
    //   console.log("error ===>", error);
    // })
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
        sessionStorage.setItem('token', response.token.id);
        this.router.navigateByUrl('/shipping-details', { skipLocationChange: true });        
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
    // this.cart = null;
    this.cartOpen = false;
    this.appservice.closeCart();
  }

}
