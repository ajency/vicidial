import { Component, OnInit, Input, OnChanges } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';

@Component({
  selector: 'app-verify-cod',
  templateUrl: './verify-cod.component.html',
  styleUrls: ['./verify-cod.component.scss']
})
export class VerifyCodComponent implements OnInit, OnChanges {

	@Input() shippingDetails : any;
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
  	console.log("verifyOTP function");
  	let url = this.appservice.apiUrl + '/api/rest/v1/user/order/' + this.shippingDetails.order_id + '/verify-otp?phone='+this.shippingDetails.address.phone+'&otp='+this.otp;
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    this.apiservice.request(url, 'get', {} , header ).then((response)=>{
    	if(response.success)
        window.location.href = "/user/order/" + this.shippingDetails.order_id +"/payment/cod";
      else{
      	this.otpVerificationFailed = true;
	      this.otpVerificationErrorMsg = response.message;
      }
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.otpVerificationFailed = true;
      this.otpVerificationErrorMsg = error.message;
      this.appservice.removeLoader();      
    }) 
  }

  cancelCOD(){
  	console.log("cancelCOD function");
  }

}
