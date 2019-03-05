import { Component, OnInit, Output, EventEmitter  } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import { AccountService } from '../services/account.service';
import { BagSummaryComponent } from '../../shared-components/bag-summary/bag-summary/bag-summary.component';
import { OrderComponent } from '../components/order/order.component';

declare var $: any;

@Component({
  selector: 'app-my-orders',
  templateUrl: './my-orders.component.html',
  styleUrls: ['./my-orders.component.css']
})
export class MyOrdersComponent implements OnInit {

  @Output() orderDetailsClick = new EventEmitter();

	orders : any = [];
  order_params = { page : 1, display_limit : 10 }
  displayShowMore : boolean = true;
  apiCallComplete : boolean = false;
  constructor(private router: Router,
						private appservice : AppServiceService,
						private apiservice : ApiServiceService,
            private account_service : AccountService) { 
  }

  ngOnInit() {
    console.log("ngOnInit my-orders");
  	this.appservice.removeLoader();    
    this.getOrders();      
  }

  ngOnDestroy(){

  }

  navigateBack(){
  	history.back();
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
        if(error.status == 401)
          this.account_service.userLogout();
        else if(error.status == 403)
          this.router.navigate(['account']);
        this.appservice.removeLoader();
        this.apiCallComplete = true;
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
  }

  updateOrderParams(){
    this.order_params.page = this.order_params.page + 1;
    this.order_params.display_limit = this.order_params.page * 10;
    this.getOrders();
  }

  navigateToOrderDetails(order){
    console.log("Order ==>", order);
    this.appservice.order = order;
    // // this.router.navigate([OrderDetailsComponent]);
    // let order_route = 'account/my-orders/' + order.order_info.txn_no;
    // this.router.navigate([order_route]);
    this.appservice.order_txn_no = order.order_info.txn_no;
    this.orderDetailsClick.emit();
  }

}
