import { Directive, AfterViewInit, ElementRef } from '@angular/core';

@Directive({
  selector: '[appKssAutoFocus]'
})
export class KssAutoFocusDirective implements AfterViewInit {

	constructor(private elementRef: ElementRef) { };

  ngAfterViewInit(): void {
  	console.log("kss auto focus");
  	// setTimeout(()=>{
  		this.elementRef.nativeElement.focus();
  	// },500)
    
  }

}
