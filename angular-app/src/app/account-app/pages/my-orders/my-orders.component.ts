import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../services/app-service.service';
import { ApiServiceService } from '../../services/api-service.service';

import { BagSummaryComponent } from '../../../shared-components/bag-summary/bag-summary/bag-summary.component';
import { OrderComponent } from '../../components/order/order.component';
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

  constructor(private router: Router,
						private appservice : AppServiceService,
						private apiservice : ApiServiceService,) { 
  }

  ngOnInit() {
    console.log("ngOnInit my-orders");
  	// this.appservice.removeLoader();
    if(this.appservice.isLoggedInUser()){
    	this.getOrders();      
    }
    else
      this.appservice.removeLoader();

  }

  navigateToBlank(){
  	this.router.navigateByUrl('/blank');
  }

  getOrders(){
    this.appservice.showLoader();
    // let url = 'https://demo8558685.mockable.io/orders';
    let url = this.appservice.apiUrl + '/api/rest/v1/user/orders';
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    let body : any = {
      _token : $('meta[name="csrf-token"]').attr('content')
    };
    // body.page = this.order_params.page;
    // body.display_limit = this.order_params.display_limit;

    this.apiservice.request(url, 'post', body , header ).then((response)=>{
      if(!response.data.length)
        this.displayShowMore = false;
      let formatted_data = this.formattedCartDataForUI(response.data);
    	this.orders = this.orders.concat(formatted_data);
    	console.log("orders ==>", this.orders);
      this.appservice.removeLoader();
      this.apiCallComplete = true;
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
    }) 
  }

  formattedCartDataForUI(data){
    data.forEach((order)=>{
      order.sub_orders.forEach((sub_order)=>{
        sub_order.items.forEach((item)=>{
          if(item.price_mrp != item.price_final)
            item.off_percentage = Math.round(((item.price_mrp - item.price_final) / (item.price_mrp )) * 100) + '% OFF';
          item.href = '/' + item.product_slug +'/buy?size='+item.size;
          item.images = Array.isArray(item.images) ? ['/img/placeholder.svg', '/img/placeholder.svg', '/img/placeholder.svg'] : Object.values(item.images);
        })
      })
    })
    return data;
  }

  isLoggedIn(){
    return this.appservice.isLoggedInUser();
  }

  closeWidget(){
    let url = window.location.href.split("#")[0];
    history.replaceState({}, 'account', url);
    this.appservice.closeWidget();
    window.location.reload();
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

}
