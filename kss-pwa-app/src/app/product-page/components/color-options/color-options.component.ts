import { Component, OnInit, Input, OnChanges } from '@angular/core';
import { Router }  from '@angular/router';
@Component({
  selector: 'app-color-options',
  templateUrl: './color-options.component.html',
  styleUrls: ['./color-options.component.scss']
})
export class ColorOptionsComponent implements OnInit, OnChanges {

	@Input() colorVariants : any;
  @Input() collapse : any;

  selectedColorVariant : any;
  constructor(private router: Router) { }

  ngOnInit() {
  }

  ngOnChanges(){
  	// console.log("colorVariants ==>", this.colorVariants, this.collapse)
    this.selectedColorVariant = this.colorVariants.find((variant)=>{return variant.is_selected === true})
  }

  trim(color){
    return color.replace(/\s/g, "");
  }

  openColorVariant(variant){
    if(!variant.is_selected)
      this.router.navigateByUrl((new URL(variant.url)).pathname);
      // window.location.href = variant.url;
  }

}
