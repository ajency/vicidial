import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../services/app-service.service';
import { LoginComponentComponent } from '../../../shared-components/login/login-component/login-component.component';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs/Subscription';

declare var $: any;

@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.css']
})
export class AccountComponent implements OnInit {

	closeModalSubscription: Subscription;
  openModalSubscription : Subscription;

  constructor(private appservice : AppServiceService,
  			  private router : Router) {
  	        this.closeModalSubscription = this.appservice.listenToCloseModal().subscribe(()=>{ this.closeLoginModal()});
	        this.openModalSubscription = this.appservice.listenToOpenModal().subscribe(()=>{ this.modalHandler()});
  	}

  ngOnInit() {
  	this.appservice.removeLoader();
  	if(!this.appservice.isLoggedInUser())
  		this.displayModal();
  }

  ngOnDestroy(){
    this.closeModalSubscription.unsubscribe();
    this.openModalSubscription.unsubscribe();
  }

  isLoggedIn(){
    return this.appservice.isLoggedInUser();
  }

  displayModal(){
    let url = window.location.href +'/user-verification';
    if(!window.location.href.endsWith('#/account/user-verification'))
      history.pushState({cart : true}, 'cart', url);
    $('#signin').modal('show');
    $('.modal-backdrop').appendTo('#cd-cart');
    $('body').addClass('hide-scroll');
  }

  loginSucessTriggered(){
  	history.back();
  }

   closeLoginModal(){   	
    $('#signin').modal('hide');
    $("#cd-cart").css("overflow", "auto");
    if(this.appservice.redirectUrl.endsWith('/my-orders') && this.appservice.isLoggedInUser()){
    	console.log("navigate to my-orders");
  		// this.router.navigateByUrl('account/my-orders');
  		this.router.navigate(['account/my-orders']);
  		this.appservice.redirectUrl = '';
    }
    // this.mobileNumberEntered = false;
    // this.otp = null;
    // this.otpCode.otp1 =''; this.otpCode.otp2 = ''; this.otpCode.otp3 = ''; this.otpCode.otp4 = ''; this.otpCode.otp5 = ''; this.otpCode.otp6='';
    // this.userValidation.otpVerificationErrorMsg = '';
  }

  modalHandler(){
    if(!this.appservice.isLoggedInUser())
      this.displayModal();    
  }

}
