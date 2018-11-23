import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../services/app-service.service';
import { ApiServiceService } from '../../services/api-service.service';


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
  	this.getOrders();
  }

  navigateToBlank(){
  	this.router.navigateByUrl('/blank');
  }

  getOrders(){
    this.appservice.showLoader();
    let url = 'https://demo8558685.mockable.io/orders';
    // let url = this.appservice.apiUrl + '/api/rest/v1/user/save-user-details';
    // let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    // let body : any = {
    //   _token : $('meta[name="csrf-token"]').attr('content'),
    //   name : this.shippingDetails.user_info.name,
    //   email : this.shippingDetails.user_info.email
    // };

    this.apiservice.request(url, 'get', {} , {} ).then((response)=>{
    	this.orders = response.data;
    	console.log("orders ==>", this.orders);
      this.appservice.removeLoader();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.appservice.removeLoader();
    }) 
  }

}
