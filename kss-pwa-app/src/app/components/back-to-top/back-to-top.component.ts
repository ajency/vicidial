import { Component, OnInit } from '@angular/core';

import * as $ from 'jquery';

@Component({
  selector: '[app-back-to-top]',
  templateUrl: './back-to-top.component.html',
  styleUrls: ['./back-to-top.component.scss']
})
export class BackToTopComponent implements OnInit {

  constructor() { }

  ngOnInit() {

  	$(window).scroll(function() {
         if ($(this).scrollTop() > 300) {
             $('.go-top').fadeIn(200);
         } else {
             $('.go-top').fadeOut(200);
         }
     });
     // Animate the scroll to top
     $('.go-top').click(function(event) {
         event.preventDefault();
         $('html, body').animate({
             scrollTop: 0
         }, 300);
     })
  }

}
