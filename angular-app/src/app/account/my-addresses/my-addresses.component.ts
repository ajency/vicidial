import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';

import { AddressComponent } from '../../shared-components/address/address/address.component';
declare var $: any;

@Component({
  selector: 'app-my-addresses',
  templateUrl: './my-addresses.component.html',
  styleUrls: ['./my-addresses.component.css']
})
export class MyAddressesComponent implements OnInit {
	
	addAddress = false;
  addresses : any;
  states : any;
  selectedAddressId : any;

  constructor(private appservice : AppServiceService,
              private apiservice : ApiServiceService) { }

  ngOnInit() {
  	this.states = this.appservice.states.length ? this.appservice.states : this.getAllStates();
  	this.getAddress();
  }

  getAddress(){
    this.appservice.showLoader();
    this.appservice.callGetAllAddressesApi().then((response)=>{
      this.addresses = response.addresses;
      // this.checkAddresses();
      this.appservice.shippingAddresses = response.addresses;
      this.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.addresses = [];
      this.removeLoader();
    })
  }

  closeWidget(){
    let url = window.location.href.split("#")[0];
    history.replaceState({}, 'account', url);
    this.appservice.closeCart();
    // window.location.reload();
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
}
