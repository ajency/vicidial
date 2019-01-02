import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';
import { Router, ActivatedRoute} from '@angular/router';
import { Subscription } from 'rxjs/Subscription';

declare var $: any;

@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.css']
})
export class AccountComponent implements OnInit {

  returnUrl: string;
  loginCheckTimer : any;
  constructor(private appservice : AppServiceService,
      			  private router : Router,
              private route: ActivatedRoute) {
  	}

  ngOnInit() {
    this.returnUrl = this.route.snapshot.queryParams['return_url'];
    console.log("this.returnUrl ==>", this.returnUrl);
  	this.appservice.removeLoader();
  	if(!this.appservice.isLoggedInUser())
  		this.displayModal();
  }

  ngOnDestroy(){
    this.clearLoginTimerInterval();
  }

  isLoggedIn(){
    return this.appservice.isLoggedInUser();
  }

  displayModal(){
    this.checkLoginTimer();
    this.router.navigate([{ outlets: { popup: ['user-login'] }}], { replaceUrl: true });
  }

  redirectToReturnUrl(){
    if(this.returnUrl)  	
      this.router.navigateByUrl(this.returnUrl, { replaceUrl: true });
  }

  closeWidget(){
    let url = window.location.href.split("#")[0];
    history.replaceState({}, 'account', url);
    this.appservice.closeCart();
  }

  checkLoginTimer(){
    this.clearLoginTimerInterval();
    console.log("inside checkLoginTimer function");
    this.loginCheckTimer = setInterval(()=>{
      if(this.appservice.isLoggedInUser()){
        this.redirectToReturnUrl();
        this.clearLoginTimerInterval();
      }
    },100)
  }

  clearLoginTimerInterval(){
    if(this.loginCheckTimer)
      clearInterval(this.loginCheckTimer);
  }

}
