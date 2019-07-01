import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-order-sidebar',
  templateUrl: './order-sidebar.component.html',
  styleUrls: ['./order-sidebar.component.scss']
})
export class OrderSidebarComponent implements OnInit {
	@Input() orderDetails : any;
  constructor() { }

  ngOnInit() {
  }

}
