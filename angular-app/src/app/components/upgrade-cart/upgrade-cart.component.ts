import { Component,  OnInit, Input, OnChanges, SimpleChanges} from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-upgrade-cart',
  templateUrl: './upgrade-cart.component.html',
  styleUrls: ['./upgrade-cart.component.css']
})
export class UpgradeCartComponent implements OnInit, OnChanges{
	@Input() promotions : any;
	@Input() orderTotal : any;

	upgradeCoupon : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  }

  ngOnChanges(changes: SimpleChanges) {
    // console.log("ngOnChanges upgrade-cart component", this.promotions, this.orderTotal);
    let filterd_obj = this.appservice.filterArray(this.promotions, this.orderTotal);
    let sorted_array = this.appservice.sortArray(filterd_obj.non_applicable);
    this.upgradeCoupon = sorted_array[0];
    // console.log(this.upgradeCoupon);
  }
}
