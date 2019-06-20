import { Component, OnInit, Input } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';
import { AppServiceService } from '../../../service/app-service.service';

@Component({
  selector: 'app-order-message',
  templateUrl: './order-message.component.html',
  styleUrls: ['./order-message.component.scss']
})
export class OrderMessageComponent implements OnInit {

	@Input() status : any;
	@Input() orderInfo : any;
	@Input() trackBackUrl : any;
	iframeSrc : any;
  tradeTrackerIFrame : any;
  constructor(private sanitizer: DomSanitizer,
              private appservice : AppServiceService) { 
  	
  }

  ngOnInit() {
  }

  ngOnChanges(){
  	if(this.orderInfo){
	  	this.iframeSrc = this.sanitizer.bypassSecurityTrustResourceUrl("https://af0y.com/p.ashx?o=301&e=225&t="+ this.orderInfo['txn_no'] + "&ect=" +this.orderInfo['total_amount'] + "&p=" +this.orderInfo['total_amount']);
      this.tradeTrackerIFrame = this.sanitizer.bypassSecurityTrustResourceUrl("https://ts.tradetracker.net/?cid=30735&pid=47044&tgi=&tid=" + this.orderInfo['txn_no'] + "&tam=" + this.orderInfo['total_amount'] + "&descrMerchant={descrMerchant}&descrAffiliate=" + this.orderInfo['txn_no'] + "&currency={currency}&data=" + this.orderInfo['txn_no'] + "&vc={voucherCode}");
	  }

    if(this.status == 'success' || this.status == 'cod'){
      this.getNewCartId();
      document.cookie = "cart_count=" + 0 + ";path=/";
      this.appservice.updateCartCountInUI();
      this.appservice.clearSessionStorage();
    }
  }

  openCart(){
    this.appservice.loadCartFromAngular = true;
    let url = window.location.href.split("#")[0] + '#/bag';
    history.pushState({bag : true}, 'bag', url);
    this.appservice.loadCartTrigger();
  }

  getNewCartId(){
    this.appservice.callMineApi().then((response)=>{
        document.cookie="cart_id=" + response.cart_id + ";path=/";
    })
    .catch((error)=>{
      console.log("error : mine api===>", error);
    })
  }

}
