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
  userInfo : any;
  loginSucessListener : Subscription;

  constructor(private appservice : AppServiceService,
      			  private router : Router,
              private route: ActivatedRoute) {
      this.loginSucessListener = this.appservice.listenToLoginSuccess().subscribe(()=>{ this.redirectToReturnUrl() });
  	}

  ngOnInit() {
    this.returnUrl = this.route.snapshot.queryParams['return_url'];
    console.log("this.returnUrl ==>", this.returnUrl);
  	this.appservice.removeLoader();
  	if(!this.appservice.isLoggedInUser())
  		this.displayModal();
    else
      this.getUserInfo();
  }

  getUserInfo(){
    if(this.appservice.userInfo)
      this.userInfo = this.appservice.userInfo;
    else{
      this.appservice.getUserInfo().then((response) =>{
        this.userInfo = response.user_info;
        this.appservice.userInfo = response.user_info;
        this.appservice.removeLoader();
      })
      .catch((error)=>{
        console.log("error in get-user-info api ==>",error);
        this.appservice.removeLoader();
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
    this.router.navigate([{ outlets: { popup: ['user-login'] }}], { replaceUrl: true });
  }

  redirectToReturnUrl(){
    setTimeout(()=>{
      if(this.returnUrl)    
        this.router.navigateByUrl(this.returnUrl, { replaceUrl: true });
    },100)
  }

  closeWidget(){
    let url = window.location.href.split("#")[0];
    history.replaceState({}, 'account', url);
    this.appservice.closeCart();
  }

}