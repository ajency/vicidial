import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';

import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import { AccountService } from '../services/account.service';

import * as moment from 'moment';
// import 'rxjs/add/operator/switchMap';

declare var $: any;

@Component({
  selector: 'app-order-details',
  templateUrl: './order-details.component.html',
  styleUrls: ['./order-details.component.scss']
})

export class OrderDetailsComponent implements OnInit {
  
  order : any;
  orders : any;
  showBackButton : boolean = false;
  cancelOrder : boolean = false;
  getCancelReason : any;
  reasons : any;
  cancelReasonId : any;
  additionalRemark = '';
  cancelSuccessful : boolean = false;
  returnSuccessful : boolean = false;
  cancelOrderFailureMsg : any;
  returnItem : boolean = false;
  cancelItemsList : any = [];
  quantity = 1;
  unverifiedUser : boolean = false;
  cdnUrl : any;
  constructor(private appservice : AppServiceService,
              private route: ActivatedRoute,
              private router: Router,
              private account_service : AccountService,
              private apiservice : ApiServiceService) { }
  
  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
    this.appservice.removeLoader();
    $("#cd-my-account").scrollTop(0);
    if(this.appservice.order)
      this.showBackButton = true;  
    this.getOrderDetails();   
  }

  ngOnDestroy(){
    this.unsubscribeGetCancelReason();
  }

  getOrderDetails(){
    this.appservice.showLoader();
    let order_id = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);
    let url = this.appservice.apiUrl + '/api/rest/v2/user/order/'+ order_id +'/details';
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      _token : $('meta[name="csrf-token"]').attr('content')
    };
    this.apiservice.request(url, 'get', body , header).then((response)=>{
      this.order = response.data;
      this.appservice.removeLoader();
    })
    .catch((error)=>{
      if(error.status == 401)
        this.account_service.userLogout();
      else if(error.status == 403){
        this.order = false;
        if(error.error.message === 'Unverified User')
          this.unverifiedUser = true;
      }
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
    this.cancelItemsList = Object.assign([], this.order.items)
    this.cancelOrder = true;
    this.callGetReasonsApi();
  }

  callGetReasonsApi(){
    $('#cd-cart').addClass('overflow-h');
    this.unsubscribeGetCancelReason();
    // let url = this.appservice.apiUrl +  "/api/rest/v2/district-state"
    if(this.account_service.reasons){
        this.reasons = this.cancelOrder ? this.account_service.reasons.cancel : this.account_service.reasons.return;
        this.cancelReasonId = 0;
    }
    else{
      this.appservice.showLoader();
      // let url = "https://demo8558685.mockable.io/cancel-reason";
      let url = this.appservice.apiUrl + "/api/rest/v2/get-all-reasons";
      this.getCancelReason = this.apiservice.request(url, 'get', {}, {}, false, 'observable').subscribe((response)=>{
        console.log("response from location api ==>", response);
        response.cancel.push({id : 0, value : '--Select--' });
        response.return.push({id : 0, value : '--Select--' });
        this.account_service.reasons = response;
        this.reasons = this.cancelOrder ? this.account_service.reasons.cancel : this.account_service.reasons.return;
        this.cancelReasonId = 0;
        this.appservice.removeLoader();     
      },
      (error)=>{
        console.log("error ===>", error);
        this.appservice.removeLoader();
      })
    }
    this.cancelOrderFailureMsg = '';
  }

  unsubscribeGetCancelReason(){
    if(this.getCancelReason)
      this.getCancelReason.unsubscribe();
  }

  checkCancelReason(){
    // console.log("checkCancelReason ==>", this.cancelReasonId)
    // this.cancelReasonId = parseInt(this.cancelReasonId);
  }

  confirm(){
    this.cancelOrder ? this.callCancelOrderApi() : this.callReturnOrderApi();
  }

  callCancelOrderApi(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl +  "/api/rest/v2/user/order/" + this.order.order_info.order_id +"/cancel";
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      reason : this.cancelReasonId,
      comments : this.additionalRemark
    };
    console.log("cancel body ==>", body);
    this.updateOrder(url,body,header)
  }

  callReturnOrderApi(){
    this.appservice.showLoader();
    let url = this.appservice.apiUrl +  "/api/rest/v2/user/sub-order/" + this.cancelItemsList[0].suborder_id +"/return";
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      reason : this.cancelReasonId,
      comments : this.additionalRemark,
      variant_id : this.cancelItemsList[0].variant_id,
      quantity : this.cancelItemsList[0].quantity
    };
    console.log("cancel body ==>", body);
    this.updateOrder(url,body,header)
  }

  updateOrder(url, body, header){
    this.apiservice.request(url, 'post', body , header ).then((response)=>{      
      $('#cd-cart').animate({
          scrollTop: 0
      });
      this.cancelOrder ? this.cancelSuccessful = true : this.returnSuccessful = true;
      this.getOrderDetails();
      this.closeCancelOrder();
    })
    .catch((error)=>{
      $('#cd-cart').animate({
          scrollTop: 0
      });
      console.log("error ===>", error);
      this.closeCancelOrder();
      if(error.status == 0){
        this.cancelOrderFailureMsg = "Item return failed. Please check your Internet Connection";  
      }
      else{
        this.cancelOrderFailureMsg = error.error.message;
      }
      this.appservice.removeLoader();
    }) 
  }



  closeCancelOrder(){
    $('#cd-cart').removeClass('overflow-h');
    this.cancelOrder = false;
    this.returnItem = false;
    this.cancelReasonId = '';
    this.additionalRemark = '';
  }

  openReturnItem(item){
    console.log("item to be returned ==>", item);
    let item_copy = Object.assign({}, item);
    this.cancelItemsList = [item_copy];
    this.quantity = item.quantity;
    this.returnItem = true;
    this.callGetReasonsApi();
  }

  openQuantityModal(){
    $('#qty-modal-account').modal('show');
    $("#cd-my-account").css("overflow-y", "hidden");
    $('.modal-backdrop').appendTo('.order-cancel');

    $('#qty-modal-cart').on('hidden.bs.modal', function (e) {
      $("#cd-cart").css("overflow-y", "auto");
    })
  }

  updateQuantity(quantity){
    this.cancelItemsList[0].quantity = quantity;
  }

  getValidTill(date){
    return moment(date, "YYYY-MM-DD HH:mm:ss").format("DD MMM, YYYY");
  }

  displayModal(){
    this.appservice.displaySkipOTP = false;
    this.appservice.showLoginPopupTrigger();
  }
  
}
