import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router'
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import { BagSummaryComponent } from '../../shared-components/bag-summary/bag-summary/bag-summary.component';

declare var $: any;
// declare var fbTrackInitiateCheckout : any;

@Component({
  selector: 'app-shipping-summary',
  templateUrl: './shipping-summary.component.html',
  styleUrls: ['./shipping-summary.component.css']
})
export class ShippingSummaryComponent implements OnInit {

  shippingDetails : any;
  showUserInfoModal : boolean = false;
  showCancelButton : boolean = false;
  userName : any;
  userEmail : any;
  constructor(private router : Router,
  			   		private appservice : AppServiceService,
              private apiservice : ApiServiceService,
              private route : ActivatedRoute
  					) { }

  ngOnInit() {
    if(this.appservice.continueOrder){
      this.appservice.continueOrder = false;
      this.callContinueOrderApi();
    }
    else
      this.callCreateOrderApi();
    this.updateUrl();
  }

  navigateToPaymentPage(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + '/api/rest/v1/user/order/' + this.shippingDetails.order_id + '/check-inventory'
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    this.apiservice.request(url, 'get', {} , header ).then((response)=>{
      window.location.href = "/user/order/" + this.shippingDetails.order_id +"/payment/payu";
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
      this.appservice.removeLoader();      
    })      
  }
  
  closeCart(){
    let url = window.location.href.split("#")[0];
    history.pushState({cart : false}, 'cart', url);
    window.location.reload();
  }

  navigateBack(){
    history.back();
  }

  updateUrl(){
    let url = window.location.href.split("#")[0] + '#shipping-summary';
    console.log("check url ==>", url);
    history.pushState({cart : true}, 'cart', url);      
  }

  callCreateOrderApi(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + '/api/rest/v1/user/cart/' + this.appservice.getCookie('cart_id') + '/create-order'
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      address_id : this.appservice.selectedAddressId
    };
    body._token = $('meta[name="csrf-token"]').attr('content');
    this.appservice.selectedAddressId = '';
    this.apiservice.request(url, 'post', body , header ).then((response)=>{
      this.shippingDetails = this.getProductUrl(response);
      this.setUserName();
      this.appservice.removeLoader();
      // fbTrackInitiateCheckout(this.shippingDetails.summary.final_price);
      // this.appservice.updateCartId();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
      this.appservice.removeLoader();      
    })  
  }

  callContinueOrderApi(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + '/api/rest/v1/user/cart/' + this.appservice.getCookie('cart_id') + '/continue-order';
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      _token : $('meta[name="csrf-token"]').attr('content')
    };

    if(this.appservice.selectedAddressId){
      body.address_id = this.appservice.selectedAddressId
      this.appservice.selectedAddressId = '';
    }

    this.apiservice.request(url, 'post', body , header ).then((response)=>{
      this.shippingDetails = this.getProductUrl(response);
      this.setUserName();
      this.appservice.removeLoader();
      // fbTrackInitiateCheckout(this.shippingDetails.summary.final_price);
      // this.appservice.updateCartId();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
      this.appservice.removeLoader();
    })  
  }

  getProductUrl(data){
    data.items.forEach((item)=>{
      item.href = '/' + item.product_slug +'/buy?size='+item.attributes.size;
      item.attributes.images = Array.isArray(item.attributes.images) ? ['/img/placeholder.svg', '/img/placeholder.svg', '/img/placeholder.svg'] : Object.values(item.attributes.images);
    })
    return data;
  }

  saveUserInfo(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + '/api/rest/v1/user/save-user-details';
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      _token : $('meta[name="csrf-token"]').attr('content'),
      name : this.shippingDetails.user_info.name,
      email : this.shippingDetails.user_info.email
    };

    this.apiservice.request(url, 'post', body , header ).then((response)=>{
      this.hideModal();
      this.userEmail = body.email;
      this.appservice.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
    }) 
  }

  setUserName(){
    if(!this.shippingDetails.user_info){
      this.shippingDetails.user_info = {};
      this.shippingDetails.user_info.name = this.shippingDetails.address.name;
      this.shippingDetails.user_info.email = '';
      setTimeout(()=>{
        this.showModal();  
      },100);
      
    }
    else{
      this.userEmail = this.shippingDetails.user_info.email;
    }
  }

  editUserInfo(){
    this.showCancelButton = true;
    this.showModal();    
  }

  showModal(){
    this.showUserInfoModal = true;
    // var backdrop = $('.modal-backdrop');
    $('#user-info').modal('show');
    $("#cd-cart,.kss_shipping_summary").css("overflow", "hidden");
    $('.modal-backdrop').appendTo('.scroll-container');
    $('body').addClass('hide-scroll');
  }

  hideModal(){
    this.showUserInfoModal = false;
    $('#user-info').modal('hide');
    $("#cd-cart,.kss_shipping_summary").css("overflow", "auto");
    $('.modal-backdrop').remove();
  }

  editShippingAddress(){
    this.appservice.directNavigationToShippingAddress = true;
    this.appservice.editAddressFromShippingSummary = true;
    this.appservice.addressToEdit = this.shippingDetails.address;
    this.router.navigateByUrl('/shipping-details', { skipLocationChange: true });
  }

}
