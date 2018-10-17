import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';
import * as $ from 'jquery';

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.css']
})
export class CartComponent implements OnInit {

  mobileNumberEntered = false;
  enterCoupon = false;
  cart : any;
  constructor( private router: Router,
               private appservice : AppServiceService,
               private apiservice : ApiServiceService
              ) { 

  }

  ngOnInit() {
    this.getCartData();
  }

  ngAfterViewInit(){
    var self = this;
    console.log("ngAfterViewInit");
    $("#cd-cart-trigger").click(function() {
      console.log("calling getCartData function")
      self.getCartData();                       
    });
  }

  getCartData(){
    if(sessionStorage.getItem('cart_data')){
      this.cart = JSON.parse(sessionStorage.getItem('cart_data'));
      console.log("cart_data from sessionStorage==>", this.cart);
    }
    else{
      let url = 'http://localhost:8000/rest/anonymous/cart/get';
      this.apiservice.request(url, 'get', {} ).then((response)=>{
        console.log("response ==>", response);
        this.cart = response;
        sessionStorage.setItem('cart_data', JSON.stringify(this.cart));
      })
      .catch((error)=>{
        console.log("error ===>", error);
        if(error.message == "Cart not found for this session"){
          this.cart = {
            items : []
          }
        }
      })
    }
  }

  modifyCart(item){
    // console.log("inside modifyCart function ==>", item);
    // let body;
    // body = {
    //   old_item : item.id,
    //   new_item : item.related_items.size.find(size=> size.value == item.attributes.size).id,
    //   quantity : item.quantity
    // }
    // console.log("Body ==>", body);
    // let url = 'http://localhost:8000/rest/anonymous/cart/update';
    // this.apiservice.request(url, 'get', body ).then((response)=>{
    //   console.log("response ==>", response);
    //   item = response.item;
    //   sessionStorage.setItem('cart_data', JSON.stringify(this.cart));
    // })
    // .catch((error)=>{
    //   console.log("error ===>", error);
    // })
  }

  deleteItem(item){
    // console.log("delete item ==>", item);
    // let body = {
    //   item_id : item.id
    // }
    // let url = 'http://localhost:8000/rest/anonymous/cart/delete';
    // this.apiservice.request(url, 'get', body ).then((response)=>{
    //   console.log("response ==>", response);
    //   let index = this.cart.items.findIndex(i => i.id == item.id)
    //   this.cart.items.splice(index,1);
    //   sessionStorage.setItem('cart_data', JSON.stringify(this.cart));
    // })
    // .catch((error)=>{
    //   console.log("error ===>", error);
    // })
  }

  verifyMobile(){
  	this.router.navigateByUrl('/shipping-details', { skipLocationChange: true });
  }

  closeCart(){
    this.cart = null;
    this.appservice.closeCart();
  }

}
