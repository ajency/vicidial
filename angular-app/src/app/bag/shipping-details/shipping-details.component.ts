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
    default : false
  };
  selectedAddressId : any;
  states : any;
  hideDefaultAddressField : boolean = false;
  cart : any;
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
      if(this.states && this.states.length) 
        this.initSelectPicker(); 
    }
    else if(this.appservice.editAddressFromShippingSummary){
      this.appservice.editAddressFromShippingSummary = false;
      let address = this.addresses.find((add)=>{ return add.id == this.appservice.addressToEdit.id})
      this.editAddress(address);
    }
    this.addresses.forEach((address)=> {if(address.default == true) this.selectedAddressId=address.id});
  }

  updateUrl(){
    // let url = window.location.href.split("#")[0] + '#shipping-address';
    // console.log("check url ==>", url);
    // if(!window.location.href.endsWith('#shipping-address')){
    //   this.appservice.userVerificationComplete ? history.replaceState({cart : true}, 'cart', url) : history.pushState({cart : true}, 'cart', url);
    //   this.appservice.userVerificationComplete = false;
    // }      
  }

  checkCartStatus(){
    if(!this.appservice.isLoggedInUser()){
       this.router.navigateByUrl('/bag');
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
          this.router.navigateByUrl('/bag');
        }
      })
      .catch((error)=>{
        console.log("error ===>", error);
        this.appservice.removeLoader();
        this.router.navigateByUrl('/bag');
      })
    }
  }

  getAddress(){
    this.appservice.showLoader();
    this.appservice.callGetAllAddressesApi().then((response)=>{
      this.addresses = response.addresses;
      this.checkAddresses();
      this.updateUrl();
      this.appservice.shippingAddresses = response.addresses;
      this.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.addresses = [];
      this.removeLoader();
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
    this.newAddress.state_id="";
    this.newAddress.landmark = "";
    this.initSelectPicker();
  }

  initSelectPicker(){
    $(".kss_shipping").scrollTop(0);
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
    if (this.cart && this.cart.cart_type == "order")
      this.appservice.continueOrder = true;
    this.router.navigateByUrl('bag/shipping-summary');      
  }

  closeCart(){
    let url = window.location.href.split("#")[0];
    history.pushState({cart : false}, 'cart', url);
    window.location.reload();
  }

  navigateBack(){
    history.back();
  }

  getAllStates(){    
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + "/rest/v1/anonymous/states/all";
    this.apiservice.request(url, 'get', {}, {} ).then((response)=>{
      this.appservice.states = response;
      this.states = response;
      this.initSelectPicker();
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

  getStateName(id){
    if(this.states){
      let state_obj = this.states.find((state)=>{ return id == state.id});
      return state_obj.state;
    }    
  }
}
