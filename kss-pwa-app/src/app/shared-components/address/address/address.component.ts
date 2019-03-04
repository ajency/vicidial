import { Component, OnInit, Input, OnChanges, Output, EventEmitter } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';
import { ApiServiceService } from '../../../service/api-service.service';
import { NumbersDirective } from '../../../directives/numbers.directive';

declare var $: any;

@Component({
  selector: 'app-address',
  templateUrl: './address.component.html',
  styleUrls: ['./address.component.css']
})
export class AddressComponent implements OnInit, OnChanges {

	@Input() addresses : any;
	@Input() addAddress : any;
	@Input() selectedAddressId : any;
	@Input() states : any;
  @Input() hideRadio : any;

  @Output() addAddressFlagChanged = new EventEmitter();

	newAddress : any = {
    name : '',
    phone : '',
    address : '',
    pincode : '',
    landmark : '',
    city : '',
    state_id : '',
    default : false
  };
  hideDefaultAddressField : boolean = false;
  phoneOnBlur : boolean = false;
  pincodeBlur : boolean = false;
  getLocationCall : any;
  pincodeErrorMsg : any;
  showPicodeLoader : boolean = false;
  constructor(private appservice : AppServiceService,
              private apiservice : ApiServiceService) { }

  ngOnInit() {
  }

  ngOnChanges(){
  	// console.log("ngOnChanges address component ==>", this.addresses, this.addAddress, this.selectedAddressId, this.states);
    this.checkAddresses();
    if(this.states && this.states.length) 
      this.initSelectPicker(false); 
  }

  ngOnDestroy() {
    this.unsubscribeGetLocationCall();
  }

  checkAddresses(){
    if(!this.addresses.length){
      this.addAddress = true;
      this.newAddress.phone = this.appservice.userMobile;
      this.addAddressFlagChanged.emit(true);
      if(this.states && this.states.length) 
        this.initSelectPicker(); 
    }
    else if(this.appservice.editAddressFromShippingSummary){
      this.appservice.editAddressFromShippingSummary = false;
      let address = this.addresses.find((add)=>{ return add.id == this.appservice.addressToEdit.id})
      this.editAddress(address);
    }
    this.addresses.forEach((address)=> {if(address.default == true) this.selectedAddressId=address.id});
    // this.addAddressFlagChanged.emit(true);
  }

  editAddress(address){
    this.newAddress = Object.assign({}, address);
    this.hideDefaultAddressField = address.default ? true : false;
    this.addAddress = true;
    this.addAddressFlagChanged.emit(true);
    this.initSelectPicker();
  }

  initSelectPicker(scroll : boolean = true){
    if(scroll){
      $(".kss_shipping").animate({scrollTop: 0}, 300);
      $('#cd-cart').animate({scrollTop: 0}, 300);
    }    
    setTimeout(()=>{
      // $('#state').selectpicker();
      // $('[data-toggle="tooltip"]').tooltip();
    },100); 
  }

  addNewAddress(){
    this.hideDefaultAddressField = false;
    this.addAddress = true;
    this.addAddressFlagChanged.emit(true);
    this.newAddress = {};
    this.newAddress.default = false;
    this.newAddress.state_id="";
    this.newAddress.landmark = "";
    this.newAddress.phone = this.appservice.userMobile;
    this.newAddress.pincode = "";
    this.initSelectPicker();
  }

  setAddressDefault(id){
    this.addresses.forEach((address)=>{
      if(address.id == id)
        address.default = true;
    })
  }

  changeAddreessDefault(id){
    this.addresses.forEach((address)=>{
      if(address.id != id)
        address.default = false;
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
      this.addAddressFlagChanged.emit(false);
      this.appservice.shippingAddresses = this.addresses;
      this.newAddress = {};
      this.appservice.removeLoader();
      this.addAddressFlagChanged.emit(true);
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
      // this.addAddress = false;
      // this.addAddressFlagChanged.emit(false);
    })    
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
      this.addAddressFlagChanged.emit(true);
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
    })
  }

  getStateName(id){
    if(this.states && id){
      let state_obj = this.states.find((state)=>{ return id == state.id});
      return state_obj.state;
    }    
  }

  updatedAddAddress(){
    this.addAddress = false;
    this.addAddressFlagChanged.emit(false);
  }

  getCityState(pincode){
    if(pincode.length == 6){
      console.log("make api call");
      this.showShowLoader();
      this.unsubscribeGetLocationCall();
      let url = this.appservice.apiUrl +  "/api/rest/v1/district-state/"+pincode;
      this.getLocationCall = this.apiservice.request(url, 'get', {}, {}, false, 'observable').subscribe((response)=>{
        console.log("response from location api ==>", response);
        this.newAddress.city = response.district;
        this.newAddress.state_id = response.state_id;
        this.removeLoader();
      },
      (error)=>{
        console.log("error ===>", error);
        this.resetStateAndCity();
        this.removeLoader();
        if(error.status == 403)
          this.pincodeErrorMsg = "We do not service this pincode.";
        else if(error.status == 0)
          this.pincodeErrorMsg = "Failed to verify pincode. Please check your internet connection."
        else
          this.pincodeErrorMsg = "Failed to verify pincode. Please re-enter pincode.";
      })
    }
    else{
      this.unsubscribeGetLocationCall();
      this.resetStateAndCity();
      this.pincodeErrorMsg = "";
    }
  }

  unsubscribeGetLocationCall(){
    if(this.getLocationCall)
      this.getLocationCall.unsubscribe();
  }

  showShowLoader(){
    this.showPicodeLoader = true;
  }

  removeLoader(){
    this.showPicodeLoader = false;
  }

  resetStateAndCity(){
    this.newAddress.city = '';
    this.newAddress.state_id = '';
  }

}
