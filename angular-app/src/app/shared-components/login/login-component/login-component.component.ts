import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';
import { ApiServiceService } from '../../../service/api-service.service';

declare var $: any;

@Component({
  selector: 'app-login-component',
  templateUrl: './login-component.component.html',
  styleUrls: ['./login-component.component.css']
})
export class LoginComponentComponent implements OnInit {

	@Output() loginSuccess = new EventEmitter();

	mobileNumberEntered = false;
  mobileNumber : any;
  otp : any;
  otpCode = {otp1:"",otp2:"",otp3:"",otp4:"",otp5:"",otp6:""}
  userValidation = {
    disableSendOtpButton :  false,
    mobileValidationFailed : false,
    mobileValidationErrorMsg : '',
    disableVerifyOtpButton : false,
    otpVerificationFailed : false,
    otpVerificationErrorMsg : ''
  }

  constructor(private appservice : AppServiceService,
  						private apiservice : ApiServiceService) { }

  ngOnInit() {
  }

  authenticateUser(){
    this.userValidation.disableSendOtpButton = true;
    this.userValidation.mobileValidationFailed = false;
    let url = this.appservice.apiUrl + '/rest/v1/authenticate/generate_otp?';
    let body = { phone : this.mobileNumber };
    url = url+$.param(body);
    this.apiservice.request(url, 'get', body , {}, true).then((response)=>{
      this.userValidation.disableSendOtpButton = false;
      if(response.success){
        this.mobileNumberEntered = true;
      }
      else{
        this.userValidation.mobileValidationFailed = true;
        this.userValidation.mobileValidationErrorMsg = response.message
      }
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.userValidation.disableSendOtpButton = false;
      this.userValidation.mobileValidationFailed = true;
    })
  }

  verifyMobile(){
    this.userValidation.disableVerifyOtpButton = true;
    this.userValidation.otpVerificationFailed = false;
    let url = this.appservice.apiUrl + '/rest/v1/authenticate/login?';
    this.otp=this.otpCode.otp1+this.otpCode.otp2+this.otpCode.otp3+this.otpCode.otp4+this.otpCode.otp5+this.otpCode.otp6
    let body = {
      otp : this.otp,
      phone : this.mobileNumber
    }
    url = url + $.param(body);
    this.apiservice.request(url, 'get', body, {}, true).then((response)=>{
      this.otp = null;
      this.userValidation.disableVerifyOtpButton = false;
      if(response.success){
        document.cookie='token='+ response.token + ";path=/";
        document.cookie='cart_id=' + response.user.active_cart_id + ";path=/";
        this.appservice.userVerificationComplete = true;
        // this.updateOtpModal(false);
        $('body').removeClass('modal-open')
        // this.navigateToShippingDetailsPage();
        this.loginSuccess.emit();        
      }
      else{
        this.userValidation.otpVerificationErrorMsg = response.message;
        this.userValidation.otpVerificationFailed = true;
      }

    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.userValidation.disableVerifyOtpButton = false;
      this.userValidation.otpVerificationFailed = true;
    })  	
  }

  onKeyDown(event,el1,el2,value) {
    console.log("onKeyDown event ",value, event.which, event.keyCode);
    if( ((event.which > 47 && event.which < 58) || (event.which > 95 && event.which < 106)) && value){
      el2.focus();
      console.log('onKeyDown funtion call el2');
    }
    // else if(event.which == 8){
    //   el1.focus();
    //   console.log('next funtion call el1');
    // }
    if (event.keyCode === 13) {
      console.log('enter keycode');
      $('.is-enter').click();
    }
  }

  onKeyUp(event,el1,el2, value) {
    console.log("onKeyUp event ",value, event.which, event.keyCode);
    if(((event.which > 47 && event.which < 58) || (event.which > 95 && event.which < 106)) && value){
      el2.focus();
      console.log('onKeyUp funtion call el2');
    }
    if(event.key=="Backspace"){
       el1.focus();
       console.log('onKeyUp funtion call el1');
     }
    // else
    //   el2.focus();
    if (event.keyCode === 13) {
      $('.is-enter').click();
      console.log('enter keycode');
    }
   }

  check_OTP(){
    if(this.otpCode.otp1=='' || this.otpCode.otp2=='' || this.otpCode.otp3=='' || this.otpCode.otp4=='' || this.otpCode.otp5=='' || this.otpCode.otp6=='')
      return true;
  }

  enterclick(event){
      if (event.keyCode === 13) {
        $('.is-enter').click();
      }
  }

  closeOtpModal(){
    history.back();
  }

}
