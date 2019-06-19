import { Injectable } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import { Router } from '@angular/router'
import { Observable, Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class BagService {

  private closeWidget = new Subject<any>();

  constructor(private appservice : AppServiceService,
              private apiservice : ApiServiceService,
              private router : Router) { }


  confirmOrderPayment(order_id){
  	this.appservice.showLoader();
  	let url = this.appservice.apiUrl + '/api/rest/v2/user/order/' + order_id + '/payment/cod'
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    this.apiservice.request(url, 'get', {} , header ).then((response)=>{
      this.closeWidgetTrigger();
    	this.router.navigateByUrl('/order/details/'+response.txnid,{ replaceUrl: true });
    })
    .catch((error)=>{
      this.appservice.removeLoader();      
      let url = window.location.href.split("#")[0] + '#/bag';
      history.replaceState({bag : true}, 'bag', url);
      this.appservice.loadCartTrigger();
    })      
  }

  closeWidgetTrigger(){
    this.closeWidget.next();
  }

  listenTocloseWidgetTriggerr() : Observable<any> {    
    return this.closeWidget.asObservable();
  }
}
