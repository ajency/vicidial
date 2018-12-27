import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';

import { BagSummaryComponent } from '../../shared-components/bag-summary/bag-summary/bag-summary.component';
import { OrderComponent } from '../components/order/order.component';
// import { LoginComponentComponent } from '../../../shared-components/login/login-component/login-component.component';

declare var $: any;

@Component({
  selector: 'app-my-orders',
  templateUrl: './my-orders.component.html',
  styleUrls: ['./my-orders.component.css']
})
export class MyOrdersComponent implements OnInit {

	orders : any = [];
  order_params = { page : 1, display_limit : 10 }
  displayShowMore : boolean = true;
  apiCallComplete : boolean = false;
  loginCheckTimer : any;
  constructor(private router: Router,
						private appservice : AppServiceService,
						private apiservice : ApiServiceService,) { 
  }

  ngOnInit() {
    console.log("ngOnInit my-orders");
  	this.appservice.removeLoader();
    if(this.appservice.isLoggedInUser()){
    	this.getOrders();      
    }
    else{
      this.appservice.removeLoader();
      this.displayModal();
    }

  }

  ngOnDestroy(){
    this.clearLoginTimerInterval();
  }

  navigateToBlank(){
  	this.router.navigateByUrl('/blank');
  }

  getOrders(){
    if(this.appservice.myOrders){
      this.orders = this.appservice.myOrders;
      this.apiCallComplete = true;
    }
    else{
      this.appservice.showLoader();
     
      this.appservice.getOrders().then((response)=>{
        let formatted_data = this.appservice.formattedCartDataForUI(response.data);
        this.orders = formatted_data;
        this.appservice.myOrders = this.orders;
        console.log("orders ==>", this.orders);
        this.appservice.removeLoader();
        this.apiCallComplete = true;
      })
      .catch((error)=>{
        console.log("error ===>", error);
        this.appservice.removeLoader();
      }) 
    }
  }

  isLoggedIn(){
    return this.appservice.isLoggedInUser();
  }

  closeWidget(){
    let url = window.location.href.split("#")[0];
    history.replaceState({}, 'account', url);
    this.appservice.closeCart();
    // window.location.reload();
  }

  updateOrderParams(){
    this.order_params.page = this.order_params.page + 1;
    this.order_params.display_limit = this.order_params.page * 10;
    this.getOrders();
  }

  navigateToOrderDetails(order){
    console.log("Order ==>", order);
    this.appservice.order = order;
    // this.router.navigate([OrderDetailsComponent]);
    let order_route = 'account/my-orders/' + order.order_info.txn_no;
    this.router.navigate([order_route]);
  }

  displayModal(){
    this.checkLoginTimer();
    this.router.navigate([{ outlets: { popup: ['user-login'] }}], { replaceUrl: true });
  }

  checkLoginTimer(){
    this.clearLoginTimerInterval();
    console.log("inside checkLoginTimer function");
    this.loginCheckTimer = setInterval(()=>{
      if(this.appservice.isLoggedInUser()){
        this.getOrders();
        this.clearLoginTimerInterval();
      }
    },100)
  }

  clearLoginTimerInterval(){
    if(this.loginCheckTimer)
      clearInterval(this.loginCheckTimer);
  }

}
