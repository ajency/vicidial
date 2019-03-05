import { Component, OnInit,  Input, OnChanges, Output } from '@angular/core';
import * as $ from 'jquery';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit, OnChanges {

	@Input() menu : any;
  constructor(private appservice : AppServiceService,){ }

  ngOnInit(){
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
