import { Component, OnInit, ViewChild, Output, EventEmitter } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import { AccountService } from '../services/account.service';
import { Router, ActivatedRoute} from '@angular/router';

import { AddressComponent } from '../../shared-components/address/address/address.component';
declare var $: any;

@Component({
  selector: 'app-my-addresses',
  templateUrl: './my-addresses.component.html',
  styleUrls: ['./my-addresses.component.css']
})
export class MyAddressesComponent implements OnInit {

  @Output() closeMyAddresses = new EventEmitter();
  @ViewChild(AddressComponent)
  private addressComponent : AddressComponent
	
	addAddress = false;
  addresses : any;
  states : any;
  selectedAddressId : any;
  cdnUrl : any;
  constructor(private appservice : AppServiceService,
              private apiservice : ApiServiceService,
              private account_service : AccountService,
              private router : Router) { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
  	this.states = this.appservice.states.length ? this.appservice.states : this.getAllStates();
  	this.getAddress();
  }

  getAddress(){
    if(this.appservice.shippingAddresses && this.appservice.shippingAddresses.length){
      this.addresses = this.appservice.shippingAddresses;
      this.removeLoader();
    }
    else{
      this.appservice.showLoader();
      this.appservice.callGetAllAddressesApi().then((response)=>{
        this.addresses = response.addresses;
        this.appservice.userMobile = response.user_info.mobile;
        // this.checkAddresses();
        this.appservice.shippingAddresses = response.addresses;
        this.removeLoader();
      })
      .catch((error)=>{
        console.log("error ===>", error);
        this.addresses = [];
        if(error.status == 401)
          this.account_service.userLogout();
        else if(error.status == 403){
          // this.router.navigate(['account']);
          this.closeMyAddresses.emit();
        }
        this.removeLoader();        
      })
    }
  }

  closeWidget(){
    let url = window.location.href.split("#")[0];
    history.replaceState({}, 'account', url);
    this.appservice.closeCart();
    // window.location.reload();
  }

  navigateBack(){
    if(this.addAddress && this.addresses.length){
      this.addAddress = false;
    }
    else
      this.closeMyAddresses.emit();

    // history.back();
  }

  getAllStates(){    
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + "/rest/v2/anonymous/states/all";
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
  }
}
