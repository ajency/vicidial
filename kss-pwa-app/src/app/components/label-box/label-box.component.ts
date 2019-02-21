import { Component, OnInit, Input, OnChanges, AfterViewInit, Output, EventEmitter } from '@angular/core';
import { AppService } from '../../services/app.service';

@Component({
  selector: '[app-label-box]',
  templateUrl: './label-box.component.html',
  styleUrls: ['./label-box.component.scss']
})
export class LabelBoxComponent implements OnInit {
	@Input() box_data : any;
	@Input() box_type : any;
  constructor() { }

  ngOnInit() {
  }

  createDataSrcSet(a,b,c,d,e,f){
    return a+ " " +b +", " +c +" "+d +", " +e +" "+f;
  }

}
