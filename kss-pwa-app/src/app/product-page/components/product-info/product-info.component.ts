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
  @Input() colorVariants : any;
  @Input() selectedColorVariant : any;
  @Input() queryParamSize : any;
  @Input() inventoryData : any;
  @Input() isSellable : any;
  @Input() sizeChart : any;
  selectedSize : any;
  isMobile : any;
  shakeSizes : boolean = false;
  selectedModalSize : any;
  modalSizeSelectError : boolean = false;
  outOfStock : boolean = true;  
  selectedQuantity = 1;
  totalQuantity = 0;
  constructor(private appservice : AppServiceService,
              private apiservice : ApiServiceService,
              private breakpointObserver : BreakpointObserver) {
      this.isMobile = this.breakpointObserver.isMatched('(max-width: 600px)');
    }

  ngOnInit() {

  }

  ngOnChanges(){
  	this.variants = this.variants.sort((a,b)=>{ return a.variant_facets.variant_size.sequence - b.variant_facets.variant_size.sequence});
    if(this.inventoryData){
      for(const [key, value] of Object.entries(this.inventoryData.variants)) {
        console.log("key value",key,value);
        if(value > 0)
          this.outOfStock = false
        let v = this.variants.find((v)=>{return v.variant_attributes.variant_id == key})
        if(v && value)
          v.is_available = true;
      }
      if(this.queryParamSize){
        let variant = this.variants.find((v)=>{ return this.queryParamSize == v.variant_facets.variant_size.name});
        if(variant && this.inventoryData.variants[variant.variant_attributes.variant_id]){
          this.selectedSize = this.selectedModalSize = variant.variant_attributes.variant_id;
          this.selectedQuantity = 1;
          this.totalQuantity = 5;
          if(this.inventoryData.variants[this.selectedSize] < 5)
            this.totalQuantity = this.inventoryData.variants[this.selectedSize];
        }
      }
    }
  	// console.log("attributes =>", this.colorVariants, this.queryParamSize);
  }

  getOffPercentage(list_price, sale_price){
  	return this.appservice.calculateOff(list_price, sale_price);
  }

  sizeSelected(){
    $('.size-select-error').addClass('d-none');
    console.log("inside updatePriceprice", this.selectedSize)
    let variant = this.variants.find((v)=>{ return this.selectedSize == v.variant_attributes.variant_id});
    this.replaceURLParameter('size', variant.variant_facets.variant_size.name);

    if(this.inventoryData.variants[this.selectedSize]){
      this.totalQuantity = 5;
      if(this.inventoryData.variants[this.selectedSize] < 5)
        this.totalQuantity = this.inventoryData.variants[this.selectedSize];
      this.selectedQuantity = 1;
    }
  }

  modalSizeSelected(){
    this.selectedSize = this.selectedModalSize;
    this.sizeSelected();
  }

  replaceURLParameter(paramName, paramValue) {
    let url = window.location.href;
    let hash = window.location.hash;
    url = url.replace(hash, '');
    if (url.indexOf(paramName + "=") >= 0) {
       let prefix = url.substring(0, url.indexOf(paramName));
       let suffix = url.substring(url.indexOf(paramName));
       suffix = suffix.substring(suffix.indexOf("=") + 1);
       suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
       url = prefix + paramName + "=" + paramValue + suffix;
    } else {
       if (url.indexOf("?") < 0) url += "?" + paramName + "=" + paramValue;
       else url += "&" + paramName + "=" + paramValue;
    }
    url = url.substring(url.indexOf(window.location.pathname));
    window.history.replaceState({}, 'Kidsuperstore.in', url + hash);
  }

  addToBag(){
    console.log("variant id==>",this.selectedSize);
    if(this.selectedSize){
      this.appservice.loadCartFromAngular = true;
      this.appservice.add_to_cart_clicked = true;
      let url = window.location.href.split("#")[0] + '#/bag';
      history.pushState({bag : true}, 'bag', url);
      console.log("openCart");
      this.appservice.loadCartTrigger();    
      this.addToBagApiCall();
    }
    else{
      if(this.isMobile){
          if($('#size-modal').hasClass('show')){
            this.modalSizeSelectError = true;
            this.shakeSizes = true;
            setTimeout(()=>{
              this.shakeSizes = false;
            },200);
          }
          $('#size-modal').modal('show');
      }
      else{
          $('.size-select-error').removeClass('d-none');
          this.shakeSizes = true;
          setTimeout(()=>{
            this.shakeSizes = false;
          },200);
      }
    }
  }

  removeCartLoader(){
    $('#size-modal').modal('hide');
    // $('.kss_sizes .radio-input').prop('checked', false);
    this.selectedSize = '';
    this.selectedModalSize = '';
    this.totalQuantity = 0;
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
      variant_quantity : this.selectedQuantity
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
    this.appservice.add_to_cart_completed = true;
    document.cookie = "cart_count=" + response.cart_count + ";path=/";
    this.appservice.updateCartCountInUI();
  }

  addToBagErrorHandler(error){
    console.log("error ===>", error);
    $('.cd-add-to-cart').removeClass('cartLoader');
    $('#size-modal').modal('hide');
    if(error.status == 401){
      this.appservice.userLogout();
      this.showErrorPopup(error);
    }
    else if(error.status == 0){
        this.showErrorPopup(error);
    }
    else if(!this.appservice.isLoggedInUser() && error.status == 403){
        this.addToBag();
    }
    else{
        if(this.appservice.isLoggedInUser() && error.status == 400 || error.status == 403){
            this.getNewCartId();
        }
        else{
            this.showErrorPopup(error);
        }
    }
  }

  showErrorPopup(error){
      let error_msg = (error.error && error.error.message && error.error.message != '') ? error.error.message : 'Could not add to bag';
      this.appservice.add_to_cart_failed = true;
      this.appservice.add_to_cart_completed = true;
      this.appservice.add_to_cart_failure_message = error_msg=='Quantity not available' ? 'Could not add '+ this.attributes.product_title +' to bag as it is out of stock' : (error_msg == "invalid cart" ? 'Hey, before you add your item to bag it looks like you were interrupted during your last checkout. You can place this existing order or edit bag to add more items.' : 'Due to the high traffic, there was an issue adding your item to bag. Please try adding the item again' );

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

  updateQuantity(quantity){
    console.log("quantity updated ==>",quantity);
    this.selectedQuantity = quantity;
  }
}