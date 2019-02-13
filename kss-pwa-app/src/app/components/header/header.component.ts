import { Component, OnInit,  Input, OnChanges } from '@angular/core';
import * as $ from 'jquery';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit, OnChanges {

	@Input() menu : any;

  constructor(){ }

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
  	console.log("ngOnChanges header", this.menu);
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
}
