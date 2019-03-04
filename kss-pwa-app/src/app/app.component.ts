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
  loadFromAngular : boolean = false;
  displayLogin : boolean = false;
  loginListner : Subscription;
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
    if(this.appservice.loadFromAngular){
      $('#main-nav').removeClass('speed-in');
      $('#cd-cart').addClass("speed-in");
      $('#cd-shadow-layer').addClass('is-visible');
      $("body").addClass("hide-scroll");
      setTimeout(()=>{
        this.loadFromAngular = true;
      },500)      
    }
    else{
      this.loadCart = true;
    }    
  }

  listenToHashChange(){
    this.loc.onHashChange(()=>{
      // console.log("On popstate location: ", document.location);
      if(window.location.href.endsWith('#/') || window.location.href.endsWith('#') || (!window.location.href.includes("#")) ){
          this.appservice.closeCart();
        }
      if(window.location.href.endsWith('#/bag') || window.location.href.endsWith('#/bag/shipping-address') || window.location.href.endsWith('#/bag/shipping-summary')){
        this.appservice.updateCartViewTrigger();
      }
    });
  }

  openLoginModal(){
    console.log("openLoginModal function");
    this.displayLogin = true;
  }
}

