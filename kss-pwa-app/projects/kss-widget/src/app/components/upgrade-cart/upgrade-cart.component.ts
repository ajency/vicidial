import { Component,  OnInit, Input, OnChanges, SimpleChanges, Output, EventEmitter} from '@angular/core';
import { AppServiceService } from '../../service/app-service.service';

@Component({
  selector: 'app-upgrade-cart',
  templateUrl: './upgrade-cart.component.html',
  styleUrls: ['./upgrade-cart.component.css']
})
export class UpgradeCartComponent implements OnInit, OnChanges{
	@Input() promotions : any;
	@Input() orderTotal : any;
  @Output() noUpgradePromo = new EventEmitter();
	upgradeCoupon : any;
  constructor(private appservice : AppServiceService) { }

  ngOnInit() {
  }

  ngOnChanges(changes: SimpleChanges) {
    // console.log("ngOnChanges upgrade-cart component", this.promotions, this.orderTotal);
    let filterd_obj = this.appservice.filterArray(this.promotions, this.orderTotal);
    let sorted_array = this.appservice.sortArray(filterd_obj.non_applicable);
    if(sorted_array.length)
      this.upgradeCoupon = sorted_array[0];
    else
      this.noUpgradePromo.emit();
    // console.log(this.upgradeCoupon);
  }
}
