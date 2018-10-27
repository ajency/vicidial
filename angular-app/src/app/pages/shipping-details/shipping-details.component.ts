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
  showCartLoader : boolean = false;
  newAddress : any = {
    name : '',
    phone : '',
    address : '',
    pincode : '',
    locality : '',
    landmark : '',
    city : '',
    state : '',
    default : false,
    type : "Home"
  };
  selectedAddressId : any;
  constructor( private router : Router,
               private appservice : AppServiceService,
               private apiservice : ApiServiceService

            ) { }

  ngOnInit() {
    this.addresses = this.appservice.shippingAddresses;
    if(!this.addresses.length)
      this.addAddress = true;
    this.addresses.forEach((address)=> {if(address.default == true) this.selectedAddressId=address.id});
  }

  saveNewAddress(){
    this.showCartLoader = true;
    let url = this.appservice.apiUrl + this.newAddress.id ? "/api/rest/v1/user/address/edit" :  "/api/rest/v1/user/address/new";
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {};
    body = this.newAddress;
    body._token = $('meta[name="csrf-token"]').attr('content');

    console.log("body ==>", body);
    this.apiservice.request(url, 'post', body , header ).then((response)=>{
      console.log("response ==>", response);
      if(this.newAddress.id){
        let editAddress = this.addresses.find(address => address.id == this.newAddress.id);
        editAddress = response.address;
      }
      else{
        this.addresses.push(response.address);
      }
      this.addAddress = false;
      this.appservice.shippingAddresses = this.addresses;
      this.newAddress = {};
      this.showCartLoader = false;
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.showCartLoader = false;
      this.addAddress = false;
    })    
  }

  editAddress(address){
    console.log(address);
    this.newAddress = address;
    this.addAddress = true;
  }

  navigateToShippingPage(){
    console.log(this.selectedAddressId);
  	// this.router.navigateByUrl('/shipping-summary', { skipLocationChange: true })
  }

  closeCart(){
    this.appservice.closeCart();
  }
}
