import { Component, OnInit, Input, OnChanges } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';
import { ApiServiceService } from '../../../service/api-service.service';

declare var $ : any;
@Component({
  selector: 'app-product-info',
  templateUrl: './product-info.component.html',
  styleUrls: ['./product-info.component.scss']
})
export class ProductInfoComponent implements OnInit, OnChanges {

	@Input() attributes : any;
	@Input() facets : any;
	@Input() variants : any;

  selectedSize : any;
  constructor(private appservice : AppServiceService,
              private apiservice : ApiServiceService) { }

  ngOnInit() {

  }

  ngOnChanges(){
  	this.variants = this.variants.sort((a,b)=>{ return a.variant_facets.variant_size.sequence - b.variant_facets.variant_size.sequence});
  	console.log("attributes =>", this.attributes, this.facets);
  }

  getOffPercentage(list_price, sale_price){
  	return this.appservice.calculateOff(list_price, sale_price);
  }

  updatePrice(){
    console.log("inside updatePriceprice", this.selectedSize)
  }

  addToBag(){
    console.log("variant id==>",this.selectedSize);
    let url = this.appservice.apiUrl + (this.appservice.isLoggedInUser() ? ("/api/rest/v1/user/cart/"+this.appservice.getCookie('cart_id')+"/insert") : ("/rest/v1/anonymous/cart/insert") )
    let body = {
      _token: $('meta[name="csrf-token"]').attr('content'),
      variant_id : this.selectedSize,
      variant_quantity : 1
    };
    let header = this.appservice.isLoggedInUser() ? { Authorization : 'Bearer '+this.appservice.getCookie('token') } : {}

    this.apiservice.request(url, 'post', body , header ).then((response)=>{

    })
    .catch((error)=>{
      console.log("error ===>", error);
      if(error.status == 401){
            this.appservice.userLogout();
        }
        else if(error.status == 0){
            // showErrorPopup(error);
        }
        else if(!this.appservice.isLoggedInUser() && error.status == 403){
            this.addToBag();
        }
        else{
            if(this.appservice.isLoggedInUser() && error.status == 400 || error.status == 403){
                // getNewCartId(error);
            }
            else{
                // showErrorPopup(error);
            }
        }
    })

  }

}
