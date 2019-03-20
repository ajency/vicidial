import { Component, OnInit, Output, EventEmitter, ElementRef, ViewChild, NgZone } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../service/app-service.service';
import { ApiServiceService } from '../service/api-service.service';
import { NumbersDirective } from '../directives/numbers.directive';

declare var $: any;

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  @ViewChild("mobileInput") private mobileInput: ElementRef;

  @ViewChild('otp1') otp1: ElementRef;
  @ViewChild('otp2') otp2: ElementRef;
  @ViewChild('otp3') otp3: ElementRef;
  @ViewChild('otp4') otp4: ElementRef;
  @ViewChild('otp5') otp5: ElementRef;
  @ViewChild('otp6') otp6: ElementRef;

  @Output() loginSuccess = new EventEmitter();

  mobileNumberState = 'mobile';
  mobileNumber : any;
  otp : any;
  signInMsg : '';
  otpCode = {otp1:"",otp2:"",otp3:"",otp4:"",otp5:"",otp6:""}
  userValidation = {
    disableGetTokenButton :  false,
    mobileValidationFailed : false,
    mobileValidationErrorMsg : '',
    disableSendOtpButton : false,
    disableVerifyOtpButton : false,
    otpVerificationFailed : false,
    otpVerificationErrorMsg : ''
  }
  displaySkipOTP : any;

  constructor(private appservice : AppServiceService,
              private apiservice : ApiServiceService,
              private router: Router,
              private zone : NgZone) { }

  ngOnInit() {
    this.displaySkipOTP = this.appservice.displaySkipOTP;
    if(!this.appservice.userInfo){
      this.displayModal();  
    }
    // else
      // this.closeOtpModal();
    
  }

  displayModal(){
     $('#signin').modal('show');
    $("#cd-cart").css("overflow", "hidden");
    $('.modal-backdrop').appendTo('#cd-cart');
    $('body').addClass('hide-scroll');
    setTimeout(()=>{
      this.mobileInput.nativeElement.focus();
    },500);
  }

  ngOnDestroy(){
    console.log("ngOnDestroy");
    $('#signin').modal('hide');
    $("#cd-cart").css("overflow", "auto");
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
  }

  authenticateUser(){
    this.userValidation.disableGetTokenButton = true;
    this.userValidation.mobileValidationFailed = false;
    let url = this.appservice.apiUrl + '/rest/v2/authenticate/get-token?';
    let body = { phone : this.mobileNumber };
    url = url+$.param(body);
    this.apiservice.request(url, 'get', body , {}, true).then((response)=>{
      this.userValidation.disableGetTokenButton = false;
      if(response.success){
        document.cookie='token='+ response.token + ";path=/";
        document.cookie='cart_id=' + response.user.active_cart_id + ";path=/";
        document.cookie='user_id=' + response.user.id + ";path=/";

        if(this.displaySkipOTP) {
          if(response.show_promt) {
            this.signInMsg = response.message;
            this.mobileNumberState = 'sign-in';
          } else {
            this.skipVerify();
          }
        } else {
          this.sendOTP();
        }
      }
      else{
        this.userValidation.mobileValidationFailed = true;
        this.userValidation.mobileValidationErrorMsg = response.message
      }
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.userValidation.disableGetTokenButton = false;
      this.userValidation.mobileValidationFailed = true;
    })
  }

  skipVerify(){
    this.closeOtpModal();
    this.appservice.loginSuccessComplete();
  }

  sendOTP(){
    this.userValidation.disableSendOtpButton = true;
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let url = this.appservice.apiUrl + '/api/rest/v2/user/authenticate/generate_otp?';
    let body = {};
    url = url+$.param(body);
    this.apiservice.request(url, 'get', body , header, true).then((response)=>{
      this.userValidation.disableSendOtpButton = false;
      if(response.success){
        this.mobileNumberState = 'verify';
      }
      else{
        //
      }
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.userValidation.disableSendOtpButton = false;
    })
  }

  reSendOTP(){
    this.userValidation.disableSendOtpButton = true;
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let url = this.appservice.apiUrl + '/api/rest/v2/user/authenticate/resend_otp?';
    let body = {};
    url = url+$.param(body);
    this.apiservice.request(url, 'get', body , header, true).then((response)=>{
      this.userValidation.disableSendOtpButton = false;
      if(response.success){
        this.mobileNumberState = 'verify';
      }
      else{
        //
      }
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.userValidation.disableSendOtpButton = false;
    })
  }

  verifyMobile(){
    this.userValidation.disableVerifyOtpButton = true;
    this.userValidation.otpVerificationFailed = false;
    let header, url, body;
    header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };   
    url = this.appservice.apiUrl + '/api/rest/v2/user/authenticate/verify-token?'
    body = {
      otp : this.otp
    }    
    // this.otp=this.otpCode.otp1+this.otpCode.otp2+this.otpCode.otp3+this.otpCode.otp4+this.otpCode.otp5+this.otpCode.otp6

    url = url + $.param(body);
    this.apiservice.request(url, 'get', body, header, true).then((response)=>{
      this.otp = null;
      this.userValidation.disableVerifyOtpButton = false;
      if(response.success){
        this.appservice.userInfo = response.user.user_info;
        document.cookie='cart_id=' + response.user.active_cart_id + ";path=/";
        this.closeOtpModal();
        this.appservice.loginSuccessComplete();
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
    if( ((event.which > 47 && event.which < 58) || (event.which > 95 && event.which < 106)) && value){
      el2.focus();
    }
    if (event.keyCode === 13) {
      $('.is-enter').click();
    }
  }

  onKeyUp(event,el1,el2, value) {
    if(((event.which > 47 && event.which < 58) || (event.which > 95 && event.which < 106)) && value){
      el2.focus();
    }
    if(event.key=="Backspace"){
       el1.focus();
     }
    if (event.keyCode === 13) {
      $('.is-enter').click();
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
    // this.router.navigate([{ outlets: { popup: null }}], {replaceUrl : true});
    $('#signin').modal('hide');
    $("#cd-cart").css("overflow", "auto");
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    this.appservice.hideLoginPopupTrigger();
  }

  /*resetOTP(){
    console.log("resetOTP updated");    
    this.mobileNumberState = false;
    this.otp = null;
    this.otpCode.otp1 =''; this.otpCode.otp2 = ''; this.otpCode.otp3 = ''; this.otpCode.otp4 = ''; this.otpCode.otp5 = ''; this.otpCode.otp6='';
    this.userValidation.otpVerificationErrorMsg = '';
  }*/

  otpVerificationIOS(otp){
    if(otp.length == 6){
      console.log("otp code length is 6")
      this.otpCode.otp1 = otp.charAt(0); 
      this.otpCode.otp2 = otp.charAt(1); 
      this.otpCode.otp3 = otp.charAt(2); 
      this.otpCode.otp4 = otp.charAt(3); 
      this.otpCode.otp5 = otp.charAt(4); 
      this.otpCode.otp6 = otp.charAt(5);

      setTimeout(()=>{          
        this.otp1.nativeElement.value = otp.charAt(0); 
        this.otp2.nativeElement.value = otp.charAt(1); 
        this.otp3.nativeElement.value = otp.charAt(2); 
        this.otp4.nativeElement.value = otp.charAt(3); 
        this.otp5.nativeElement.value = otp.charAt(4); 
        this.otp6.nativeElement.value = otp.charAt(5); 
      },20);
      this.zone.run(() => {});
      this.otp6.nativeElement.focus();
    }
  }

}
