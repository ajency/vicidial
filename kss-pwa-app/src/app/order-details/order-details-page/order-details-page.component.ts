import { Component, OnInit, isDevMode } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';
import { Router }  from '@angular/router';

declare var fbq : any;
declare var gtag : any;
declare var google_pixel_id : any;
declare var google_conversion_data : any;
declare var google_id : any;

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
  orderDetails : any;
  showLoader : boolean = true;
  paymentStatus : any; 
  trackBackUrl : any;
  orderDetailsFailure : any;
  orderDetailsTimeout : any;
  constructor(private route: ActivatedRoute,
              private apiService: ApiServiceService,
              private appservice : AppServiceService,
              private router: Router) { }

  ngOnInit() {
    this.route.params.subscribe(routeParams => {
      this.getOrderDetails(routeParams.trxn_id)
    });
    
  }

  ngOnDestroy(){
    this.unsubscribeorderDetailsCall();
    this.clearOrderDetailsTimeout();
  }

  clearOrderDetailsTimeout(){
    if(this.orderDetailsTimeout)
      clearTimeout(this.orderDetailsTimeout);
  }

  getOrderDetails(order_id){
    this.unsubscribeorderDetailsCall();
    // let order_id = this.route.snapshot.queryParamMap.get('orderid');
    let url = isDevMode() ? "https://demo8558685.mockable.io/order-details" : this.appservice.apiUrl + '/api/rest/v2/user/order/details/'+order_id;
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    this.orderDetailsCall = this.apiService.request(url,'get',{},header, false, 'observable').subscribe((response)=>{
      if(response['order-pending']){
        this.orderDetailsTimeout = setTimeout(()=>{
          this.getOrderDetails(order_id);
        },1000)
      }
      else{
        this.showLoader = false;
        this.orderDetails = response.data;
        this.paymentStatus = response.status;
        this.trackBackUrl = response.trackback_url;
        try{
          this.handleAnalytics();
        }
        catch(error){
          console.log("Analytics failure");
        }
      }
    },
    (error)=>{
      console.log("error in fetching the json",error);
      this.showLoader = false;
      this.orderDetailsFailure = true;
    });
  }

  unsubscribeorderDetailsCall(){
    if(this.orderDetailsCall)
      this.orderDetailsCall.unsubscribe();
  }

  handleAnalytics(){
    if(this.paymentStatus && (this.paymentStatus === 'success' || this.paymentStatus === 'cod')){
      let variant_ids = [], content_ids = [], id;

      this.orderDetails.items.forEach((item)=>{
        id = item.product_id + '-' + item.product_color_id
        variant_ids.push(id);
        content_ids.push({id : id, quantity : item.quantity })
      })

      fbq('track', 'Purchase', {
            value: this.orderDetails.order_info.total_amount,
            currency: 'INR',
            contents: content_ids,
            content_ids: variant_ids,
            content_type: 'product'
      });

      // Google pixel tracking
        gtag('event', 'page_view', {
          'send_to': google_pixel_id,
          'ecomm_pagetype': 'purchase',
          'ecomm_prodid': variant_ids,
          'ecomm_totalvalue': this.orderDetails.order_info.total_amount,
          'user_id': this.appservice.getCookie('user_id')
        });

        // Google Conversion tracking
        gtag('event', 'conversion', {
            'send_to': google_conversion_data,
            'value': this.orderDetails.order_info.total_amount,
            'currency': 'INR',
            'transaction_id': this.orderDetails.order_info.txn_no
        });

        // Analytics ecommerce purchase event
        gtag('event', 'purchase', {
          "send_to": google_id,
          "transaction_id": this.orderDetails.order_info.txn_no,
          "value": this.orderDetails.order_info.total_amount,
          "currency": "INR"
        });
    }
  }

}
