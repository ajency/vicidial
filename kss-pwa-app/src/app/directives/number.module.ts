import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NumbersDirective } from './numbers.directive';
import { KssAutoFocusDirective } from './kss-auto-focus.directive';
import { NgInitDirective } from './ng-init.directive';

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [NumbersDirective, KssAutoFocusDirective, NgInitDirective],
  exports : [NumbersDirective, KssAutoFocusDirective, NgInitDirective]
})
export class NumberModule { }
