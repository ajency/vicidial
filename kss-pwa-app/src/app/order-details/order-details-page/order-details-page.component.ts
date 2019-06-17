import { Component, OnInit, isDevMode } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';
import { Router }  from '@angular/router';

@Component({
  selector: 'app-order-details-page',
  templateUrl: './order-details-page.component.html',
  styleUrls: ['./order-details-page.component.scss']
})
export class OrderDetailsPageComponent implements OnInit {

	breadcrumbs : any = [
      {position: 1, title: 'Home', url: '/'},
      {position: 2, title: 'Order Details', url: ''},
  ];
  orderDetailsCall : any;
  showLoader : any;
  orderDetails : any;
  constructor(private route: ActivatedRoute,
              private apiService: ApiServiceService,
              private appservice : AppServiceService,
              private router: Router) { }

  ngOnInit() {
    this.getOrderDetails()
  }

  ngOnDestroy(){
    this.unsubscribeorderDetailsCall();
  }

  getOrderDetails(){
    this.unsubscribeorderDetailsCall();
    let order_id = this.route.snapshot.queryParamMap.get('orderid');
    let url = isDevMode() ? "https://demo8558685.mockable.io/order-details" : this.appservice.apiUrl + '/api/rest/v2/order-details/'+order_id;
    this.orderDetailsCall = this.apiService.request(url,'get',{},{}, false, 'observable').subscribe((response)=>{
      this.showLoader = false;
      this.orderDetails = response.data;
    },
    (error)=>{
      console.log("error in fetching the json",error);
      this.showLoader = false;
    });
  }

  unsubscribeorderDetailsCall(){
    if(this.orderDetailsCall)
      this.orderDetailsCall.unsubscribe();
  }

}
