import {Directive, Input, Output, EventEmitter} from '@angular/core';

@Directive({
  selector: '[appNgInit]'
})
export class NgInitDirective {

  constructor() { }

  @Input() isLast: boolean;

  @Output('appNgInit') initEvent: EventEmitter<any> = new EventEmitter();

  ngOnInit() {
    if (this.isLast) {
    	console.log("check isLast", this.isLast);
      setTimeout(() => this.initEvent.emit(), 10);
    }
  }

}
