import { Component, OnInit, ViewChild } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router'
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import { BagSummaryComponent } from '../../shared-components/bag-summary/bag-summary/bag-summary.component';
import { EditUserPopupComponent } from '../../shared-components/edit-user/edit-user-popup/edit-user-popup.component';

declare var $: any;
declare var fbTrackAddPaymentInfo : any;

@Component({
  selector: 'app-shipping-summary',
  templateUrl: './shipping-summary.component.html',
  styleUrls: ['./shipping-summary.component.css']
})
export class ShippingSummaryComponent implements OnInit {
  @ViewChild(EditUserPopupComponent)
  private editUserPopUp : EditUserPopupComponent;

  shippingDetails : any;
  showUserInfoModal : boolean = false;
  showCancelButton : boolean = false;
  userName : any;
  userEmail : any;
  widgetOpen : boolean = true;
  constructor(private router : Router,
  			   		private appservice : AppServiceService,
              private apiservice : ApiServiceService,
              private route : ActivatedRoute
  					) { }

  ngOnInit() {
    this.callOrderApi();
  }

  navigateToPaymentPage(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + '/api/rest/v1/user/order/' + this.shippingDetails.order_id + '/check-inventory'
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    this.apiservice.request(url, 'get', {} , header ).then((response)=>{
      fbTrackAddPaymentInfo();
      window.location.href = "/user/order/" + this.shippingDetails.order_id +"/payment/payu";      
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.router.navigateByUrl('/bag',{ replaceUrl: true });
      this.appservice.removeLoader();      
    })      
  }
  
  closeCart(){
    let url = window.location.href.split("#")[0];
    history.replaceState({cart : false}, 'cart', url);
    this.widgetOpen = false;
    this.appservice.closeCart();

    // window.location.reload();
  }

  navigateBack(){
    history.back();
  }

  callOrderApi(){
    this.appservice.showLoader();
    let url = this.getRequestUrl();
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      _token : $('meta[name="csrf-token"]').attr('content')
    };
    if(this.appservice.selectedAddressId){
      body.address_id = this.appservice.selectedAddressId;      
    }
    this.appservice.selectedAddressId = '';

    this.apiservice.request(url, 'post', body , header ).then((response)=>{
      this.shippingDetails = this.getProductUrl(response);
      this.setUserName();
      this.appservice.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.router.navigateByUrl('/bag', { replaceUrl: true });
      this.appservice.removeLoader();      
    })  
  }

  getRequestUrl(){
    if(this.appservice.continueOrder){
      console.log("continue-order");
      this.appservice.continueOrder = false;
      return (this.appservice.apiUrl + '/api/rest/v1/user/cart/' + this.appservice.getCookie('cart_id') + '/continue-order');
    }
    else{
      console.log("create-order");
      return (this.appservice.apiUrl + '/api/rest/v1/user/cart/' + this.appservice.getCookie('cart_id') + '/create-order');
    }    
  }

  getProductUrl(data){
    data.items.forEach((item)=>{
      item.href = '/' + item.product_slug +'/buy?size='+item.attributes.size;
      item.attributes.images = Array.isArray(item.attributes.images) ? ['/img/placeholder.svg', '/img/placeholder.svg', '/img/placeholder.svg'] : Object.values(item.attributes.images);
    })
    return data;
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

  editShippingAddress(){
    this.appservice.editAddressFromShippingSummary = true;
    this.appservice.addressToEdit = this.shippingDetails.address;
    this.router.navigateByUrl('/shipping-details', { skipLocationChange: true });
  }

  updateEmail(){
    // console.log("this.editUserPopUp.userEmail", this.editUserPopUp.userEmail, this.editUserPopUp.user_info);
    try{
      this.userEmail = this.editUserPopUp.user_info.email;
      this.appservice.userInfo = null;
    }
    catch(error){
      console.log(error);
    }
  }

  roundOff(savings){
    return new Intl.NumberFormat('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(parseFloat(savings));
  }

}