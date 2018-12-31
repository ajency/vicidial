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

	closeModalSubscription: Subscription;
  openModalSubscription : Subscription;
  returnUrl: string;
  loginCheckTimer : any;
  constructor(private appservice : AppServiceService,
      			  private router : Router,
              private route: ActivatedRoute) {
  	      this.closeModalSubscription = this.appservice.listenToCloseModal().subscribe(()=>{ this.closeLoginModal()});
	        this.openModalSubscription = this.appservice.listenToOpenModal().subscribe(()=>{ this.modalHandler()});
  	}

  ngOnInit() {
    this.returnUrl = this.route.snapshot.queryParams['return_url'] || '/';
    console.log("this.returnUrl ==>", this.returnUrl);
  	this.appservice.removeLoader();
  	if(!this.appservice.isLoggedInUser())
  		this.displayModal();
  }

  ngOnDestroy(){
    this.closeModalSubscription.unsubscribe();
    this.openModalSubscription.unsubscribe();
    this.clearLoginTimerInterval();
  }

  isLoggedIn(){
    return this.appservice.isLoggedInUser();
  }

  displayModal(){
    this.checkLoginTimer();
    this.router.navigate([{ outlets: { popup: ['user-login'] }}], { replaceUrl: true });
  }

  closeLoginModal(){   	
    this.router.navigateByUrl(this.returnUrl, { replaceUrl: true });
  }

  modalHandler(){
    if(!this.appservice.isLoggedInUser())
      this.displayModal();    
  }

  closeWidget(){
  	let url = window.location.href.split("#")[0];
    history.replaceState({}, 'account', url);
    this.appservice.closeWidget();
    // window.location.reload();
  }

  checkLoginTimer(){
    this.clearLoginTimerInterval();
    console.log("inside checkLoginTimer function");
    this.loginCheckTimer = setInterval(()=>{
      if(this.appservice.isLoggedInUser()){
        this.closeLoginModal();
        this.clearLoginTimerInterval();
      }
    },100)
  }

  clearLoginTimerInterval(){
    if(this.loginCheckTimer)
      clearInterval(this.loginCheckTimer);
  }

}
