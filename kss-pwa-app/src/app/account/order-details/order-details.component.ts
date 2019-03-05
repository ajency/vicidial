import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';

import { OrderInfoComponent } from '../components/order-info/order-info.component';
import { OrderComponent } from '../components/order/order.component';
import { ShippingAddressComponent } from '../components/shipping-address/shipping-address.component';
import { PaymentInfoComponent } from '../components/payment-info/payment-info.component';
import { OrderSummaryComponent } from '../components/order-summary/order-summary.component';

import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import { AccountService } from '../services/account.service';

// import 'rxjs/add/operator/switchMap';

declare var $: any;

@Component({
  selector: 'app-order-details',
  templateUrl: './order-details.component.html',
  styleUrls: ['./order-details.component.css']
})

export class OrderDetailsComponent implements OnInit {
  
  order : any;
  orders : any;
  showBackButton : boolean = false;
  cancelOrder : boolean = false;
  getCancelReason : any;
  cancelReasons : any;
  cancelReasonId : any;
  additionalRemark = '';
  cancelSuccessful : boolean = false;
  cancelOrderFailureMsg : any;
  constructor(private appservice : AppServiceService,
              private route: ActivatedRoute,
              private router: Router,
              private account_service : AccountService,
              private apiservice : ApiServiceService) { }
  
  ngOnInit() {
    this.appservice.removeLoader();
    $("#cd-my-account").scrollTop(0);
    if(this.appservice.order)
      this.showBackButton = true;
    // if(this.appservice.order){
    //   this.order =  this.appservice.order;
    //   this.showBackButton = true;
    // }
    // else{
    //     this.getOrders(); 
    // }    
    this.getOrderDetails();   
  }

  ngOnDestroy(){
    this.unsubscribeGetCancelReason();
  }

  getOrderDetails(){
    this.appservice.showLoader();
    // let order_id = this.route.snapshot.paramMap.get('id');
    console.log("Check order_id ==>", window.location.href.substr(window.location.href.lastIndexOf('/') + 1))
    let order_id = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);
    let url = this.appservice.apiUrl + '/api/rest/v1/user/order/'+ order_id +'/details';
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      _token : $('meta[name="csrf-token"]').attr('content')
    };
    this.apiservice.request(url, 'get', body , header).then((response)=>{
      // let formatted_data = this.formatData(response.data);
      this.order = response.data;
      console.log("order ==>", this.order);
      this.appservice.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      if(error.status == 401)
        this.account_service.userLogout();
      else if(error.status == 403)
        this.order = false;
        // this.router.navigate(['account']);
      this.appservice.removeLoader();
    })
  }

  closeWidget(){
    let url = window.location.href.split("#")[0];
    history.replaceState({}, 'account', url);
    this.appservice.closeCart();
  }

  navigateBack(){
     history.back();
  }

  findCurrentOrder(){
    let order_id = this.route.snapshot.paramMap.get('id');
    console.log("order_id ==>", order_id);
    this.order = this.orders.find((order)=>{ return order.order_info.txn_no == order_id});
  }

  openListOfOrders(){
    // this.router.navigateByUrl('account/my-orders');
    let url = window.location.href.split("#")[0] + '#/account/my-orders';
    history.replaceState({account : true}, 'account', url);
  }

  isLoggedIn(){
    return this.appservice.isLoggedInUser();
  }

    openCancelOrder(){
    $('#cd-cart').addClass('overflow-h');
    this.unsubscribeGetCancelReason();
    // let url = this.appservice.apiUrl +  "/api/rest/v1/district-state"
    if(this.account_service.cancelReasons){
        this.cancelReasons = this.account_service.cancelReasons;
        this.cancelReasonId = 0;
    }
    else{
      this.appservice.showLoader();
      // let url = "https://demo8558685.mockable.io/cancel-reason";
      let url = this.appservice.apiUrl + "/api/rest/v1/get-all-reasons";
      this.getCancelReason = this.apiservice.request(url, 'get', {}, {}, false, 'observable').subscribe((response)=>{
        console.log("response from location api ==>", response);
        response.cancel.push({id : 0, value : '--Select--' });
        this.account_service.cancelReasons = response.cancel;
        this.cancelReasons = response.cancel;
        this.cancelReasonId = 0;
        this.appservice.removeLoader();     
      },
      (error)=>{
        console.log("error ===>", error);
        this.appservice.removeLoader();
      })
    }
    this.cancelOrder = true;
    this.cancelOrderFailureMsg = '';
  }

  unsubscribeGetCancelReason(){
    if(this.getCancelReason)
      this.getCancelReason.unsubscribe();
  }

  checkCancelReason(){
    console.log("checkCancelReason ==>", this.cancelReasonId)
    // this.cancelReasonId = parseInt(this.cancelReasonId);
  }

  callCancelOrderApi(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl +  "/api/rest/v1/user/order/" + this.order.order_info.order_id +"/cancel";
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      reason : this.cancelReasonId,
      comments : this.additionalRemark
    };
    body._token = $('meta[name="csrf-token"]').attr('content');
    console.log("cancel body ==>", body);

    this.apiservice.request(url, 'post', body , header ).then((response)=>{      
      $('#cd-cart').animate({
          scrollTop: 0
      });
      this.getOrderDetails();
      this.closeCancelOrder();
      this.cancelSuccessful = true;
      this.order.cancel_allowed = false;
    })
    .catch((error)=>{
      $('#cd-cart').animate({
          scrollTop: 0
      });
      console.log("error ===>", error);
      this.closeCancelOrder();
      if(error.status == 0){
        this.cancelOrderFailureMsg = "Order Cancellation failed. Please check your Internet Connection";  
      }
      else{
        this.cancelOrderFailureMsg = error.message;
      }
      this.appservice.removeLoader();
    })  
  }

  closeCancelOrder(){
    $('#cd-cart').removeClass('overflow-h');
    this.cancelOrder = false;
    this.cancelReasonId = '';
    this.additionalRemark = '';
  }

}
