import { Component, OnInit,  Input, OnChanges, Output, isDevMode } from '@angular/core';
declare var $ : any;
import { AppServiceService } from '../../service/app-service.service';
import { ApiServiceService } from '../../service/api-service.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit, OnChanges {

  menu : any;
  constructor(private appservice : AppServiceService,
              private apiService: ApiServiceService){ }

  ngOnInit(){
    this.getMenu();
    $('.megamenu--left .nav-item').click(function(){
      var menuTab = $(this);
      menuTab.addClass('active').siblings().removeClass('active');
      var mobMenuName = menuTab.data('target');
      $('.megamenu-wrapper').addClass('d-none');
      $('.megamenu-wrapper[data-menu="'+mobMenuName+'"]').removeClass('d-none');
    });
  }

  ngOnChanges(){
  	// console.log("ngOnChanges header", this.menu);
  }

  ngAfterViewInit(){
    this.appservice.updateCartCountInUI();
  }

  getMenu(){
    if(this.appservice.menuObject)
      this.menu = this.appservice.menuObject;
    else{
      let url = isDevMode() ? "https://demo8558685.mockable.io/get-menu" : "/api/rest/v1/test/get-menu"
      this.apiService.request(url,'get',{},{}).then((data)=>{
        console.log("data ==>", data);
        this.menu = data.menu;
        this.appservice.menuObject = this.menu;
      })
      .catch((error)=>{
        console.log("error in fetching the json",error);
      })
    }
  }

  openMenu(){
  	$('.megamenu').addClass('active');
		$('.megamenu--left .nav-item:first-child').addClass('active');
		$('.megamenu--right li .megamenu-wrapper').addClass('d-none');
		$('.megamenu--right li:first-child .megamenu-wrapper').removeClass('d-none');
		$('body').addClass('overflow-h');
  }

  closeMenu(){
    $('.megamenu').removeClass('active');
    $('.megamenu--left .nav-item').removeClass('active');
    $('.megamenu-wrapper').addClass('d-none');
    $('body').removeClass('overflow-h');
  }

  openCart(){
    this.appservice.loadCartFromAngular = true;
    let url = window.location.href.split("#")[0] + '#/bag';
    history.pushState({bag : true}, 'bag', url);
    console.log("openCart");
    this.appservice.loadCartTrigger();    
  }

  openAccount(){
    this.appservice.loadAccountFromAngular = true;
    let url = window.location.href.split("#")[0] + '#/account';
    history.pushState({bag : true}, 'account', url);
    console.log("openAccount");
    this.appservice.loadCartTrigger();
  }

  createDataSrcSet(a,b,c,d){
    return a+ " " +b +", " +c +" "+d;
  }
}
