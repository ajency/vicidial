import { Component, OnInit } from '@angular/core';
import { ConnectionService } from 'ng-connection-service';
import { PlatformLocation } from '@angular/common';
import { Subscription } from 'rxjs';
import { AppServiceService } from './service/app-service.service';

declare var $ : any;

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'kss-pwa-app';
  time : any;
  isConnected : any;
  status : any;
  msg : any;
  toastTimeout : any;
  showToast : boolean = false;  
  display : boolean = false;
  loadCart : boolean = false;
  loadCartListner : Subscription;
  displayLogin : boolean = false;
  loginListner : Subscription;
  loadCartFromAngular : boolean = false;
  loadAccount : boolean = false;
  loadAccountFromAngular : boolean = false;
  hideLoginListner : Subscription;
  constructor(private connectionService: ConnectionService,
              private loc : PlatformLocation,
              private appservice : AppServiceService) { 

    this.listenToHashChange();

    this.connectionService.monitor().subscribe(isConnected => {
      console.log("event occured", isConnected);
      this.isConnected = isConnected;
      if (this.isConnected) {        
        this.status = "ONLINE";
        this.msg = "You are online!";
        this.displayToast();
        console.log("online");
        document.getElementsByTagName('body')[0].classList.remove('app-offline');                
      }
      else {        
        this.status = "OFFLINE";
        this.msg = "You are offline and may be viewing outdated info!";       
        this.displayToast();
        console.log("offline");
        document.getElementsByTagName('body')[0].classList.add('app-offline');
      }
    })

    if(!navigator.onLine){
        this.status = "OFFLINE";
        this.msg = "You are offline and may be viewing outdated info!";       
        this.displayToast();
        console.log("offline");
        document.getElementsByTagName('body')[0].classList.add('app-offline');
    }

    this.loadCartListner = this.appservice.listenToLoadCartTrigger().subscribe(()=>{  this.loadCartModule() });
    this.loginListner = this.appservice.listenToShowLoginPopupTriggerr().subscribe(()=>{ this.openLoginModal() })
    this.hideLoginListner = this.appservice.listenToHideLoginPopupTriggerr().subscribe(()=>{ this.hideLoginModal() })
  }

  displayToast(){
    clearTimeout(this.toastTimeout);  
    this.display = true;  
    this.showToast = true;
    this.toastTimeout = setTimeout(()=>{
      this.showToast = false;
    },4000)
  }

  ngOnInit(){

  }

  goToHomePage(){
		if(!navigator.onLine){
			console.log("You are offline");
			alert("You are offline");
		}
		else{
			window.location.href = "/shop";
		}
	}

  loadCartModule(){
    console.log("loadCart function");
    // if(window.location.pathname == "/newhome")
    //   this.updateOnHashChange();
    // else{
    //   this.loadModules();
    // } 
     this.loadModules();
  }

  listenToHashChange(){
    this.loc.onHashChange(()=>{
      console.log("onHashChange inside angular : ");
      this.updateOnHashChange();
    });
  }

  openLoginModal(){
    console.log("openLoginModal function");
    this.displayLogin = true;
  }

  hideLoginModal(){
    console.log("hideLoginModal function");
    this.displayLogin = false; 
  }

  updateOnHashChange(){
      if(window.location.href.endsWith('#/') || window.location.href.endsWith('#') || (!window.location.href.includes("#")) ){
          this.appservice.closeCart();
      }
      else{
        this.loadModules()
      }

      // if(window.location.href.endsWith('#/bag') || window.location.href.endsWith('#/bag/shipping-address') || window.location.href.endsWith('#/bag/shipping-summary')){
      //   this.appservice.updateCartViewTrigger();
      //   this.loadModules();
      // }

      // if(window.location.href.endsWith('#/account') || window.location.href.endsWith('#/account/my-orders') || window.location.href.includes('#/account/my-orders/')){
      //   this.appservice.updateAccountViewTrigger();
      //   this.loadModules();
      // }
  }

  loadModules(){
      if(window.location.href.includes("#/bag")){
        if(window.location.pathname == "/newhome"){
          $('#main-nav').removeClass('speed-in');
          $('#cd-cart').addClass("speed-in");
          $('#cd-shadow-layer').addClass('is-visible');
          $("body").addClass("hide-scroll");
          setTimeout(()=>{
            this.loadCartFromAngular = true;          
          },500)      
        }
        else{
          this.loadCart = true;
        }
        this.appservice.updateCartViewTrigger();
        $("app-account").addClass('d-none');
        $("app-bag-view").removeClass('d-none');  
      }
      else if(window.location.href.includes("#/account")){
        if(window.location.pathname == "/newhome"){
          $('#main-nav').removeClass('speed-in');
          $('#cd-cart').addClass("speed-in");
          $('#cd-shadow-layer').addClass('is-visible');
          $("body").addClass("hide-scroll");
          setTimeout(()=>{
            this.loadAccountFromAngular = true;
          },500)      
        }
        else{
          this.loadAccount = true;
        }
        this.appservice.updateAccountViewTrigger();
        $("app-bag-view").addClass('d-none');
        $("app-account").removeClass('d-none'); 
      }
  }
}

