import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../services/app-service.service';
import { ApiServiceService } from '../../services/api-service.service';

declare var $: any;

@Component({
  selector: 'app-my-orders',
  templateUrl: './my-orders.component.html',
  styleUrls: ['./my-orders.component.css']
})
export class MyOrdersComponent implements OnInit {

	orders : any;
  constructor(private router: Router,
						private appservice : AppServiceService,
						private apiservice : ApiServiceService,) { }

  ngOnInit() {
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

    this.apiservice.request(url, 'post', body , header ).then((response)=>{
    	this.orders = this.formattedCartDataForUI(response.data);
    	console.log("orders ==>", this.orders);
      this.appservice.removeLoader();
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
    history.back();
  }

}
