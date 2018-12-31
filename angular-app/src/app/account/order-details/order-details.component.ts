import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';

import { OrderInfoComponent } from '../components/order-info/order-info.component';
import { OrderComponent } from '../components/order/order.component';
import { ShippingAddressComponent } from '../components/shipping-address/shipping-address.component';
import { PaymentInfoComponent } from '../components/payment-info/payment-info.component';
import { OrderSummaryComponent } from '../components/order-summary/order-summary.component';

import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';

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
  
  constructor(private appservice : AppServiceService,
              private route: ActivatedRoute,
              private router: Router) { }
  
  ngOnInit() {
    this.appservice.removeLoader();
    $("#cd-my-account").scrollTop(0);
    if(this.appservice.order){
      this.order =  this.appservice.order;
      this.showBackButton = true;
    }
    else{
        this.getOrders(); 
    }    
  }

  ngOnDestroy(){

  }

  getOrders(){
    this.appservice.showLoader();
    this.appservice.getOrders().then((response)=>{
      let formatted_data = this.appservice.formattedCartDataForUI(response.data);
      this.orders = formatted_data;
      this.appservice.myOrders = formatted_data;
      this.findCurrentOrder();
      console.log("orders ==>", this.orders);
      this.appservice.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
    })
  }

  closeWidget(){
    let url = window.location.href.split("#")[0];
    history.replaceState({}, 'account', url);
    this.appservice.closeCart();
    // window.location.reload();
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

}
