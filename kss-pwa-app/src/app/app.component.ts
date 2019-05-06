import { Component, OnInit } from '@angular/core';
import { ConnectionService } from 'ng-connection-service';
import { PlatformLocation } from '@angular/common';
import { Subscription } from 'rxjs';
import { AppServiceService } from './service/app-service.service';
import { Router, Event, NavigationStart, NavigationEnd, NavigationError } from '@angular/router';

declare var $ : any;
declare var fbq : any

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
  laravelRoutes = ["/contact-us", "/contact", "/faq", "/about-us", "/terms-and-conditions", "/privacy-policy", "/ideas", "/stores", "/stores/hyderabad", "/stores/coimbatore", "/stores/jaipur", "/activities", "/my/order/details", "/shop/boys", "/shop/girls", "/shop/infants", "/draft/boys", "/draft/girls", "/draft/infants"]
  constructor(private connectionService: ConnectionService,
              private loc : PlatformLocation,
              private appservice : AppServiceService,
              private router: Router) {

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

    this.router.events.subscribe((event: Event) => {
        if (event instanceof NavigationStart) {
            // Show loading indicator
            console.log("navigattion start");
        }

        if (event instanceof NavigationEnd) {
            // Hide loading indicator
            console.log("navigattion end");
            try{
              fbq('track', 'PageView');
            }
            catch(error){
              console.log("error in fbq page view tracking");
            }
        }

        if (event instanceof NavigationError) {
            // Hide loading indicator

            // Present error to user
            console.log(event.error);
        }
    });

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
        if(window.location.pathname == '/shop/boys' || window.location.pathname == '/shop/girls' || window.location.pathname == '/shop/infants' || window.location.pathname == '/draft/boys' || window.location.pathname == '/draft/girls' || window.location.pathname == '/draft/infants' || window.location.pathname.includes('/ideas') || window.location.pathname.includes('/my/order/details') || window.location.pathname.includes('/activities') ){
            this.loadCart = true;
        }
        else{
          this.handleWidgetContainer();
          setTimeout(()=>{
            this.loadCartFromAngular = true;
          },500)
        }
        this.appservice.updateCartViewTrigger();
        $("app-account").addClass('d-none');
        $("app-bag-view").removeClass('d-none');
      }
      else if(window.location.href.includes("#/account")){
        if(window.location.pathname == '/shop/boys' || window.location.pathname == '/shop/girls' || window.location.pathname == '/shop/infants' || window.location.pathname == '/draft/boys' || window.location.pathname == '/draft/girls' || window.location.pathname == '/draft/infants' || window.location.pathname.includes('/ideas') || window.location.pathname.includes('/my/order/details') || window.location.pathname.includes('/activities') ){
            this.loadAccount = true;
        }
        else{
          this.handleWidgetContainer();
          setTimeout(()=>{
            this.loadAccountFromAngular = true;
          },500)
        }
        this.appservice.updateAccountViewTrigger();
        $("app-bag-view").addClass('d-none');
        $("app-account").removeClass('d-none');
      }
  }

  handleWidgetContainer(){
    $('#main-nav').removeClass('speed-in');
    $('#cd-cart').addClass("speed-in");
    $('#cd-shadow-layer').addClass('is-visible');
    $("body").addClass("hide-scroll");
  }
}

