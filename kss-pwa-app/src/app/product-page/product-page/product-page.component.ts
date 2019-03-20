import { Component, OnInit, isDevMode } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';
import { ApiServiceService } from '../../service/api-service.service';
import { AppServiceService } from '../../service/app-service.service';
import {BreakpointObserver, Breakpoints} from '@angular/cdk/layout';
@Component({
  selector: 'app-product-page',
  templateUrl: './product-page.component.html',
  styleUrls: ['./product-page.component.scss']
})
export class ProductPageComponent implements OnInit {

	product : any;
  showLoader : boolean = false;
  menuObject : any
  isMobile : boolean = false;
  constructor(private route: ActivatedRoute,
  			  private apiService: ApiServiceService,
              private appservice : AppServiceService,
              private breakpointObserver : BreakpointObserver) {
    this.isMobile = this.breakpointObserver.isMatched('(max-width: 600px)');
   }

  ngOnInit() {
    let url = isDevMode() ? "https://demo8558685.mockable.io/get-menu" : "/api/rest/v1/test/get-menu"
    this.apiService.request(url,'get',{},{}).then((data)=>{
      console.log("data ==>", data);
      this.menuObject = data.menu;
    })
    .catch((error)=>{
      console.log("error in fetching the json",error);
    })

    this.showLoader = true;
  	let product_slug = this.route.snapshot.paramMap.get('product_slug');
  	console.log("product_slug ==>", product_slug);

  	url = "https://demo8558685.mockable.io/get_single_product";
  	this.apiService.request(url,'get',{},{}).then((data)=>{
  		this.product = data;
      this.showLoader = false;
  		console.log("response ==>", data);
  	})
  	.catch((error)=>{
  		console.log("error in fetching the json",error);
      this.showLoader = false;
  	})
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }

  getOffPercentage(list_price, sale_price){
    return this.appservice.calculateOff(list_price, sale_price);
  }
}
