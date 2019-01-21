import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NumbersDirective } from './numbers.directive';

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [NumbersDirective],
  exports : [NumbersDirective]
})
export class NumberModule { }
