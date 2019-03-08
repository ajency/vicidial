import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NumbersDirective } from './numbers.directive';
import { KssAutoFocusDirective } from './kss-auto-focus.directive';

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [NumbersDirective, KssAutoFocusDirective],
  exports : [NumbersDirective, KssAutoFocusDirective]
})
export class NumberModule { }
