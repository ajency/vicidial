import { Component, OnInit } from '@angular/core';

declare var $: any;

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss']
})
export class FooterComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  	$('.footer-more').click(function(e){
  		e.preventDefault();
  		$(this).toggleClass('collapsed');
  		$('.hidden-footer-section').toggleClass('show');
  	});
  }

}
