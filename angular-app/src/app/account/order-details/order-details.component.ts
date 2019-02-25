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

import 'rxjs/add/operator/switchMap';

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
    let order_id = this.route.snapshot.paramMap.get('id');    
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

  formatData(order){
     order.sub_orders.forEach((sub_order)=>{
      sub_order.items.forEach((item)=>{
        if(item.price_mrp != item.price_final)
          item.off_percentage = Math.round(((item.price_mrp - item.price_final) / (item.price_mrp )) * 100) + '% OFF';
        item.href = '/' + item.product_slug +'/buy?size='+item.size;
        item.images = Array.isArray(item.images) ? ['/img/placeholder.svg', '/img/placeholder.svg', '/img/placeholder.svg'] : Object.values(item.images);
      })
    })
    return order;
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
    this.router.navigateByUrl('account/my-orders');
  }

  isLoggedIn(){
    return this.appservice.isLoggedInUser();
  }

  callCancelOrder(){
    this.unsubscribeGetCancelReason();
      // let url = this.appservice.apiUrl +  "/api/rest/v1/district-state"
      let url = "https://demo8558685.mockable.io/cancel-reason";
      this.getCancelReason = this.apiservice.request(url, 'get', {}, {}, false, 'observable').subscribe((response)=>{
        console.log("response from location api ==>", response);       
      },
      (error)=>{
        console.log("error ===>", error);
    })
    this.cancelOrder = true;
  }

  unsubscribeGetCancelReason(){
    if(this.getCancelReason)
      this.getCancelReason.unsubscribe();
  }

}
