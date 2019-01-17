import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';

import { AddressComponent } from '../../shared-components/address/address/address.component';
declare var $: any;

@Component({
  selector: 'app-shipping-details',
  templateUrl: './shipping-details.component.html',
  styleUrls: ['./shipping-details.component.css']
})
export class ShippingDetailsComponent implements OnInit {

  @ViewChild(AddressComponent)
  private addressComponent : AddressComponent

	addAddress = false;
  addresses : any;
  selectedAddressId : any;
  states : any;
  cart : any;
  widgetOpen : boolean = true;
  constructor( private router : Router,
               private appservice : AppServiceService,
               private apiservice : ApiServiceService

            ) { }

  ngOnInit() {
    this.states = this.appservice.states.length ? this.appservice.states : this.getAllStates();

    if(this.appservice.navigatingFromBagToAddress){
      this.addresses = this.appservice.shippingAddresses;
      // this.checkAddresses();
      this.appservice.navigatingFromBagToAddress = false;
      this.addresses.forEach((address)=> {if(address.default == true) this.selectedAddressId=address.id});
    }
    else{
      this.checkCartStatus();
    }  
  }

  checkCartStatus(){
    if(!this.appservice.isLoggedInUser()){
       this.router.navigateByUrl('/bag', { replaceUrl: true });
    }
    else{
      this.appservice.showLoader();
      this.appservice.callFetchCartApi().then((response)=>{
        this.cart = response;
        let cartItemOutOfStock = false;
        response.items.forEach((item)=>{
           if(!item.availability){
             cartItemOutOfStock = true;
           }
        })
        document.cookie = "cart_count=" + response.cart_count + ";path=/";
        this.appservice.updateCartCountInUI();

        if(!cartItemOutOfStock && response.items.length){
           this.getAddress();
        }
        else{
          this.router.navigateByUrl('/bag', { replaceUrl: true });
        }
      })
      .catch((error)=>{
        console.log("error ===>", error);
        this.appservice.removeLoader();
        this.router.navigateByUrl('/bag', { replaceUrl: true });
      })
    }
  }

  getAddress(){
    this.appservice.showLoader();
    this.appservice.callGetAllAddressesApi().then((response)=>{
      this.addresses = response.addresses;      
      this.appservice.shippingAddresses = response.addresses;
      this.appservice.userMobile = response.user_info.mobile;
      this.addresses.forEach((address)=> {if(address.default == true) this.selectedAddressId=address.id});
      this.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.addresses = [];
      this.removeLoader();
    })
  }

  navigateToShippingPage(){
    this.appservice.selectedAddressId = this.selectedAddressId;
    if (this.cart && this.cart.cart_type == "order")
      this.appservice.continueOrder = true;
    this.router.navigateByUrl('bag/shipping-summary');      
  }

  closeCart(){
    let url = window.location.href.split("#")[0];
    history.pushState({cart : false}, 'cart', url);
    this.widgetOpen = false;
    this.appservice.closeCart();
    // window.location.reload();
  }

  navigateBack(){
    if(this.addAddress && this.addresses.length){
      this.addAddress = false;
    }
    else
      history.back();
  }

  getAllStates(){    
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + "/rest/v1/anonymous/states/all";
    this.apiservice.request(url, 'get', {}, {} ).then((response)=>{
      this.appservice.states = response;
      this.states = response;
      // this.initSelectPicker();
      this.removeLoader();
      return response;
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.states = [];
      this.removeLoader();
      return [];
    })
  }

  removeLoader(){
    if(this.states && this.addresses){
      this.appservice.removeLoader();
    }
  }

  updateView(){
    console.log("inside updateView function");
    this.addAddress = this.addressComponent ? this.addressComponent.addAddress: this.addAddress;
    this.selectedAddressId = this.addressComponent ? this.addressComponent.selectedAddressId : this.selectedAddressId;
  }
}
