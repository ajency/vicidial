import { Component, OnInit, Input, OnChanges, Output, EventEmitter } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
declare var $: any;

@Component({
  selector: 'app-verify-cod',
  templateUrl: './verify-cod.component.html',
  styleUrls: ['./verify-cod.component.scss']
})
export class VerifyCodComponent implements OnInit, OnChanges {

	@Input() shippingDetails : any;
  @Output() hideVerifyCOD = new EventEmitter();
	otp : any;
	otpVerificationFailed : boolean = false;
	otpVerificationErrorMsg : any;
  constructor(private appservice : AppServiceService,
              private apiservice : ApiServiceService) { }

  ngOnInit() {
  }

  ngOnChanges(){
  	console.log("ngOnChanges verify-cod", this.shippingDetails);
  }

  verifyOTP(){
    this.appservice.showLoader();
  	console.log("verifyOTP function");
  	let url = this.appservice.apiUrl + '/api/rest/v1/user/order/' + this.shippingDetails.order_id + '/verify-otp?phone='+this.shippingDetails.address.phone+'&otp='+this.otp;
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    this.apiservice.request(url, 'get', {} , header ).then((response)=>{
    	if(response.success)
        window.location.href = "/user/order/" + this.shippingDetails.order_id +"/payment/cod";
      else{
      	this.otpVerificationFailed = true;
	      this.otpVerificationErrorMsg = response.message;
        this.appservice.removeLoader();
      }
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.otpVerificationFailed = true;
      this.otpVerificationErrorMsg = error.message;
      this.appservice.removeLoader();      
    }) 
  }

  showCancelModal(){
    $('#cancel-cod').modal('show');
    $("#cd-cart,.kss_shipping_summary").css("overflow", "hidden");
    $('.modal-backdrop').appendTo('.scroll-container');
    $('body').addClass('hide-scroll');
  }

  cancelCOD(){
    this.hideVerifyCOD.emit();
  }

  resendOTP(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl + '/api/rest/v1/user/order/' + this.shippingDetails.order_id + '/resend-otp?phone='+this.shippingDetails.address.phone;
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    this.apiservice.request(url, 'get', {} , header ).then((response)=>{
        this.otp = '';
        this.appservice.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      // this.router.navigateByUrl('/bag',{ replaceUrl: true });
      this.appservice.removeLoader();
    }) 
  }

}
