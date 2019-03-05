import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute} from '@angular/router';
import { Subscription } from 'rxjs';
import { AppServiceService } from '../../service/app-service.service';
import { AccountService } from '../services/account.service';

declare var $: any;

@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.css']
})
export class AccountComponent implements OnInit {

  returnUrl: string;
  userInfo : any;
  loginSucessListener : Subscription;
  openMyAddresses : boolean = false;
  openMyOrders : boolean = false;
  openMyProfile : boolean = false;
  openOrderDetails : boolean = false;
  showAccount : boolean = true;
  updateViewListner : Subscription;
  constructor(private appservice : AppServiceService,
      			  private router : Router,
              private route: ActivatedRoute,
              private account_service : AccountService) {
      this.loginSucessListener = this.appservice.listenToLoginSuccess().subscribe(()=>{ this.redirectToReturnUrl() });

       this.updateViewListner = this.appservice.listenToUpdateAccountViewTrigger().subscribe(()=>{ this.updateView() })
  	}

  ngOnInit() {
    this.returnUrl = this.route.snapshot.queryParams['return_url'];
    console.log("this.returnUrl ==>", this.returnUrl);
  	this.appservice.removeLoader();
  	if(!this.appservice.isLoggedInUser())
  		this.displayModal();
    else{
      if(window.location.href.includes('#/account/my-orders/')){
        this.openOrderDetails = true;
        this.showAccount = false;
        this.getInfo();
      }
      else if(window.location.href.endsWith('#/account/my-orders')){
        this.openMyOrders = true;
        this.showAccount = false;
        this.getInfo();
      }
      else
        this.getUserInfo();
    }
  }

  getUserInfo(){
    if(this.appservice.userInfo)
      this.userInfo = this.appservice.userInfo;
    else{
      this.appservice.showLoader();
      this.appservice.getUserInfo().then((response) =>{
        this.userInfo = response.user_info;
        this.appservice.userInfo = response.user_info;
        this.appservice.removeLoader();
      })
      .catch((error)=>{
        console.log("error in get-user-info api ==>",error);
        this.appservice.removeLoader();
        if(error.status == 401){
          this.appservice.userLogout();
          this.displayModal();
        }
        else if(error.status == 403)
          this.displayModal();
      })
    }
  }

  ngOnDestroy(){
    this.loginSucessListener.unsubscribe();
  }

  isLoggedIn(){
    return this.appservice.isLoggedInUser();
  }

  displayModal(){
    this.appservice.displaySkipOTP = false;
    // this.router.navigate([{ outlets: { popup: ['user-login'] }}], { replaceUrl: true });
    this.appservice.showLoginPopupTrigger();
  }

  redirectToReturnUrl(){
    this.userInfo = this.appservice.userInfo;
    setTimeout(()=>{
      if(this.returnUrl){
        // this.router.navigateByUrl(this.returnUrl, { replaceUrl: true });
        console.log("redirect required");
      }    
      else{
        if(!this.appservice.userInfo)
          this.getUserInfo()
      }
    },100)
  }

  closeWidget(){
    let url = window.location.href.split("#")[0];
    history.replaceState({}, 'account', url);
    this.appservice.closeCart();
  }

  openSubSection(section){
    console.log("openSubSection function", section);
    if(section == 'orders'){
      let url = window.location.href.split("#")[0] + '#/account/my-orders';
      history.pushState({account : true}, 'account', url);
      this.openMyOrders = true;
      this.openMyProfile = false;
      this.openMyAddresses = false;
      this.showAccount = false;
      this.openOrderDetails = false;
    }
    else if(section == 'profile'){
      // let url = window.location.href.split("#")[0] + '#/account/my-profile';
      // history.pushState({account : true}, 'account', url);
      this.openMyOrders = false;
      this.openMyProfile = true;
      this.openMyAddresses = false;
      this.showAccount = false;
      this.openOrderDetails = false;
    }
    else if(section == 'addresses'){
      this.openMyOrders = false;
      this.openMyProfile = false;
      this.openMyAddresses = true;
      this.showAccount = false;
      this.openOrderDetails = false;
    }
    else if(section == 'order-details'){
      let url = window.location.href.split("#")[0] + '#/account/my-orders/'+this.appservice.order_txn_no;
      history.pushState({account : true}, 'account', url);
      this.openMyOrders = false;
      this.openMyProfile = false;
      this.openMyAddresses = false;
      this.showAccount = false;
      this.openOrderDetails = true;
    }
  }

  updateView(){
    console.log("update view data ==>");
    if(window.location.href.endsWith('#/account')){
      this.openMyOrders = false;
      this.openMyProfile = false;
      this.openMyAddresses = false;
      this.showAccount = true;
      this.openOrderDetails = false;
    }
    else if(window.location.href.endsWith('#/account/my-orders')){
      this.openMyOrders = true;
      this.openMyProfile = false;
      this.openMyAddresses = false;
      this.showAccount = false;
      this.openOrderDetails = false;
    }
  }

  getInfo(){
    if(this.appservice.userInfo)
      this.userInfo = this.appservice.userInfo;
    else{
      this.appservice.getUserInfo().then((response) =>{
        this.userInfo = response.user_info;
        this.appservice.userInfo = response.user_info;
      })
      .catch((error)=>{
        console.log("error in get-user-info api ==>",error);
        if(error.status == 401){
          this.appservice.userLogout();
          this.displayModal();
        }
        else if(error.status == 403)
          this.displayModal();
      })
    }
  }
}
