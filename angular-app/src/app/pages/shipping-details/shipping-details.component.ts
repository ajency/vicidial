import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
declare var $: any;

@Component({
  selector: 'app-shipping-details',
  templateUrl: './shipping-details.component.html',
  styleUrls: ['./shipping-details.component.css']
})
export class ShippingDetailsComponent implements OnInit {

	addAddress = false;
  addresses : any;
  newAddress : any = {
    name : '',
    phone : '',
    address : '',
    pincode : '',
    locality : '',
    landmark : '',
    city : '',
    state_id : '',
    default : false,
    type : ''
  };
  selectedAddressId : any;
  states : any = [];
  hideDefaultAddressField : boolean = false;
  constructor( private router : Router,
               private appservice : AppServiceService,
               private apiservice : ApiServiceService

            ) { }

  ngOnInit() {
    this.states = this.appservice.states.length ? this.appservice.states : this.getAllStates();
    if(this.appservice.directNavigationToShippingAddress){
      this.checkCartStatus();
      this.appservice.directNavigationToShippingAddress = false;
    }
    else{
      this.addresses = this.appservice.shippingAddresses;
      this.updateUrl();
      this.checkAddresses();
    }    
  }

  checkAddresses(){
    if(!this.addresses.length){
      this.addAddress = true;
      this.initSelectPicker(); 
    }
    this.addresses.forEach((address)=> {if(address.default == true) this.selectedAddressId=address.id});
  }

  updateUrl(){
    let url = window.location.href.split("#")[0] + '#shipping-address';
    console.log("check url ==>", url);
    if(!window.location.href.endsWith('#shipping-address')){
      this.appservice.userVerificationComplete ? history.replaceState({cart : true}, 'cart', url) : history.pushState({cart : true}, 'cart', url);
      this.appservice.userVerificationComplete = false;
    }      
  }

  checkCartStatus(){
    if(!(this.appservice.getCookie('token') && this.appservice.getCookie('cart_id'))){
       this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
    }
    else{
      let url = this.appservice.apiUrl + ("/api/rest/v1/user/cart/"+this.appservice.getCookie('cart_id')+"/get");
      let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
      this.apiservice.request(url, 'get', {}, header ).then((response)=>{
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
          this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
         }
          
      })
      .catch((error)=>{
         console.log("error ===>", error);
         this.appservice.removeLoader();
         this.router.navigateByUrl('/cartpage', { skipLocationChange: true });
         return false;
      })
    }
  }

  getAddress(){
    let url = this.appservice.apiUrl + "/api/rest/v1/user/address/all";
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    this.apiservice.request(url, 'get', {} , header ).then((response)=>{
    this.addresses = response.addresses;
    this.checkAddresses();
    this.appservice.shippingAddresses = response.addresses;
    // this.router.navigateByUrl('/shipping-details', { skipLocationChange: true });
    this.appservice.removeLoader();
    })
    .catch((error)=>{
    console.log("error ===>", error);
    this.appservice.removeLoader();
    })
  }

  saveNewAddress(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + (this.newAddress.id ? "/api/rest/v1/user/address/edit" :  "/api/rest/v1/user/address/new");
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {};
    body = this.newAddress;
    body._token = $('meta[name="csrf-token"]').attr('content');

    this.apiservice.request(url, 'post', body , header ).then((response)=>{
      if(this.newAddress.id){
       this.addresses = this.addresses.map((address)=> {
        var a = address;
        if(address.id == this.newAddress.id)
          a = response.address;
        return a
      });
      }
      else{
        this.addresses.push(response.address);
      }
      if(response.address.default)
        this.changeAddreessDefault(response.address.id);

      this.selectedAddressId=response.address.id;
      this.addAddress = false;
      this.appservice.shippingAddresses = this.addresses;
      this.newAddress = {};
      this.appservice.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
      this.addAddress = false;
    })    
  }

  editAddress(address){
    this.newAddress = Object.assign({}, address);
    this.hideDefaultAddressField = address.default ? true : false;
    this.addAddress = true;
    this.initSelectPicker();
  }

  changeAddreessDefault(id){
    this.addresses.forEach((address)=>{
      if(address.id != id)
        address.default = false;
    })
  }

  setAddressDefault(id){
    this.addresses.forEach((address)=>{
      if(address.id == id)
        address.default = true;
    })
  }

  addNewAddress(){
    this.hideDefaultAddressField = false;
    this.addAddress = true;
    this.newAddress = {};
    this.newAddress.default = false;
    this.newAddress.type = "";
    this.newAddress.state_id="";
    this.newAddress.landmark = "";
    this.initSelectPicker();
  }

  initSelectPicker(){
    setTimeout(()=>{
      $('#state').selectpicker();
    },100); 
  }

  deleteAddress(id){
    let change_selected_address = (id == this.selectedAddressId) ? true : false;
    let old_id = this.selectedAddressId;
    this.appservice.showLoader();
    let body = { address_id : id };
    let url = this.appservice.apiUrl +  "/api/rest/v1/user/address/delete?";
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    url = url+$.param(body);
    this.apiservice.request(url, 'get', body, header ).then((response)=>{
      let index = this.addresses.findIndex(i => i.id == id);
      this.addresses.splice(index,1);
      if(!this.addresses.length){
        this.addNewAddress();
      }
      if(response.default_id){
        this.setAddressDefault(response.default_id);
        if(change_selected_address)
          this.selectedAddressId=response.default_id;
        else
          this.selectedAddressId = old_id;
      }
      this.appservice.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
    })
  }

  navigateToShippingPage(){
    this.appservice.selectedAddressId = this.selectedAddressId;
    this.router.navigateByUrl('/shipping-summary', { skipLocationChange: true });      
  }

  closeCart(){
    let url = window.location.href.split("#")[0];
    history.pushState({cart : false}, 'cart', url);
    window.location.reload();
    // this.appservice.closeCart();
    // console.log("history.length ==>", history.length);
    // this.appservice.cartClosedFromShippingPages = true;
    // if(history.length>2)
    //   history.go(-2);
    // else{
    //   let url = window.location.href.split("#")[0];
    //   history.replaceState({cart : false}, 'cart', url);
    //   this.appservice.closeCart();
    //   this.router.navigateByUrl('/cartpage', {skipLocationChange: true});
    // }
  }

  navigateBack(){
    history.back();
    // this.router.navigateByUrl('/', {skipLocationChange: true});
    // console.log("history.length ==>", history.length);
    // if(history.length>2)
    //   history.back();
    // else{
    //   this.appservice.cartClosedFromShippingPages = true;
    //   let url = window.location.href.split("#")[0];
    //   history.replaceState({cart : false}, 'cart', url);
    //   this.appservice.closeCart();
    //   this.router.navigateByUrl('/cartpage', {skipLocationChange: true});
    // }
  }

  getAllStates(){    
    let url = this.appservice.apiUrl + "/rest/v1/anonymous/states/all";
    this.apiservice.request(url, 'get', {}, {} ).then((response)=>{
      this.appservice.states = response;
      this.states = response;
      this.initSelectPicker();
      return response;
    })
    .catch((error)=>{
      console.log("error ===>", error);
      return [];
    })
  }
}
