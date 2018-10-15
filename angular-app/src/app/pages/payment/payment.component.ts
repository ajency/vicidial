import { Component, OnInit } from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-payment',
  templateUrl: './payment.component.html',
  styleUrls: ['./payment.component.css']
})
export class PaymentComponent implements OnInit {

  constructor( private appservice : AppServiceService) { }

  ngOnInit() {
  }

  closeCart(){
    this.appservice.closeCart();
  }
}
