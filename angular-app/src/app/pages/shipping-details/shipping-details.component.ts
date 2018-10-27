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
    let url = this.appservice.apiUrl + (this.newAddress.id ? "/api/rest/v1/user/address/edit" :  "/api/rest/v1/user/address/new");
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {};
    body = this.newAddress;
    body._token = $('meta[name="csrf-token"]').attr('content');

    this.apiservice.request(url, 'post', body , header ).then((response)=>{
      console.log("response ==>", response);
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
      this.showCartLoader = false;
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.showCartLoader = false;
      this.addAddress = false;
    })    
  }

  editAddress(address){
    this.newAddress = Object.assign({}, address);
    this.addAddress = true;
  }

  changeAddreessDefault(id){
    this.addresses.forEach((address)=>{
      if(address.id != id)
        address.default = false;
    })
  }

  addNewAddress(){
    this.addAddress = true;
    this.newAddress = {};
    this.newAddress.default = false;
    this.newAddress.type = "Home";
  }

  navigateToShippingPage(){
    console.log(this.selectedAddressId);
  	// this.router.navigateByUrl('/shipping-summary', { skipLocationChange: true })
  }

  closeCart(){
    this.appservice.closeCart();
  }
}
