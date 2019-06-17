import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-order-message',
  templateUrl: './order-message.component.html',
  styleUrls: ['./order-message.component.scss']
})
export class OrderMessageComponent implements OnInit {

	@Input() status : any;
	@Input() orderInfo : any;
  constructor() { }

  ngOnInit() {
  }

}
