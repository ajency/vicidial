import { Component, Input, OnInit } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';
declare var $ : any;

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss']
})
export class FooterComponent implements OnInit {

  @Input() stickyFoot : any;
  cdnUrl : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
    this.cdnUrl = this.appservice.cdnUrl;
  	// $('.footer-more').click(function(e){
  	// 	e.preventDefault();
  	// 	$(this).toggleClass('collapsed');
  	// 	$('.hidden-footer-section').toggleClass('show');
  	// });
  }

  openAccount(path = ''){
    this.appservice.loadAccountFromAngular = true;
    let url = window.location.href.split("#")[0] + '#/account';
    if(path)
      url = url + '/' + path;
    history.pushState({bag : true}, 'account', url);
    console.log("openAccount");
    this.appservice.loadCartTrigger();
  }

}
