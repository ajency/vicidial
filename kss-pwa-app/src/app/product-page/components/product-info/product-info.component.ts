import { Component, OnInit, Input, OnChanges } from '@angular/core';
import { AppServiceService } from '../../../service/app-service.service';
import { ApiServiceService } from '../../../service/api-service.service';
import {BreakpointObserver, Breakpoints} from '@angular/cdk/layout';
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
  isMobile : any;
  shakeSizes : boolean = false;
  constructor(private appservice : AppServiceService,
              private apiservice : ApiServiceService,
              private breakpointObserver : BreakpointObserver) {
      this.isMobile = this.breakpointObserver.isMatched('(max-width: 600px)');
    }

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
    if(this.selectedSize){
      this.appservice.loadCartFromAngular = true;
      let url = window.location.href.split("#")[0] + '#/bag';
      history.pushState({bag : true}, 'bag', url);
      console.log("openCart");
      this.appservice.loadCartTrigger();    
      this.addToBagApiCall();
    }
    else{
      if(this.isMobile){
          $('#size-modal').modal('show');
      }
      else{
          this.shakeSizes = true;
          setTimeout(()=>{
            this.shakeSizes = false;
          },200)
          $('.size-select-error').removeClass('d-none');
      }
    }
  }

  removeCartLoader(){
    $('#size-modal').modal('hide');
    // $('.kss_sizes .radio-input').prop('checked', false);
    this.selectedSize = '';
    $('.cd-add-to-cart .btn-icon').hide();
    $('.cd-add-to-cart .btn-contents').show();
    $('.cd-add-to-cart').removeClass('cartLoader');
  }

  addToBagApiCall(){
    $('.cd-add-to-cart .btn-contents').hide();
    $('.cd-add-to-cart .btn-icon').show();
    $('.cd-add-to-cart').addClass('cartLoader');

    let url = this.appservice.apiUrl + (this.appservice.isLoggedInUser() ? ("/api/rest/v1/user/cart/"+this.appservice.getCookie('cart_id')+"/insert") : ("/rest/v1/anonymous/cart/insert") )
    let body = {
      _token: $('meta[name="csrf-token"]').attr('content'),
      variant_id : this.selectedSize,
      variant_quantity : 1
    };
    let header = this.appservice.isLoggedInUser() ? { Authorization : 'Bearer '+this.appservice.getCookie('token') } : {}

    this.apiservice.request(url, 'post', body , header ).then((response)=>{
      this.removeCartLoader();
      this.addToBagSuccessHandler(response);
    })
    .catch((error)=>{
      this.addToBagErrorHandler(error);
    })
  }

  addToBagSuccessHandler(response){
    document.cookie = "cart_count=" + response.cart_count + ";path=/";
    this.appservice.updateCartCountInUI();
  }

  addToBagErrorHandler(error){
    console.log("error ===>", error);
    $('.cd-add-to-cart').removeClass('cartLoader');
    if(error.status == 401){
      this.appservice.userLogout();
    }
    else if(error.status == 0){
        this.showErrorPopup(error);
    }
    else if(!this.appservice.isLoggedInUser() && error.status == 403){
        this.addToBag();
    }
    else{
        if(this.appservice.isLoggedInUser() && error.status == 400 || error.status == 403){
            // getNewCartId(error);
        }
        else{
            this.showErrorPopup(error);
        }
    }
  }

  showErrorPopup(error){
      let error_msg = (error && error.message && error.message != '') ? error.message : 'Could not add to bag';
      this.appservice.add_to_cart_failed = true;
      this.appservice.add_to_cart_completed = true;
      this.appservice.add_to_cart_failure_message = error_msg=='Quantity not available' ? 'Could not add '+ this.attributes.product_name +' to bag as it is out of stock' : (error_msg == "invalid cart" ? 'Hey, before you add your item to bag it looks like you were interrupted during your last checkout. You can place this existing order or edit bag to add more items.' : 'Due to the high traffic, there was an issue adding your item to bag. Please try adding the item again' );

      $('.cd-add-to-cart .btn-icon').hide();
      $('.cd-add-to-cart .btn-contents').show();
      $('.cd-add-to-cart .kss-btn__wrapper').addClass('d-flex');
      $('.cd-add-to-cart .kss-btn__wrapper').removeClass('d-none');
      $('.cd-add-to-cart').removeClass('cartLoader');
  }

  getNewCartId(){
    // this.appservice.showLoader();
    this.appservice.callMineApi().then((response)=>{
      document.cookie = "cart_id=" + response.cart_id + ";path=/";
      if(response.cart_type == 'cart')
          this.addToBagApiCall(); 
      else
          this.startFresh()
    })
    .catch((error)=>{
      console.log("error : mine api===>", error);
      this.showErrorPopup(error);
      // this.appservice.removeLoader();
    })
  }

  startFresh(){
    let url = this.appservice.apiUrl + '/api/rest/v1/user/cart/start-fresh';
    let header = { Authorization : 'Bearer '+this.appservice.getCookie('token') };
    this.apiservice.request(url, 'get', {} , header ).then((response)=>{
      document.cookie='cart_id=' + response.cart_id + ";path=/";
      this.addToBagApiCall();
    })
    .catch((error)=>{
      console.log("error ===>", error);
      this.showErrorPopup(error);
    })
  }
}
