import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BagSummaryComponent } from './bag-summary/bag-summary.component';

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [BagSummaryComponent],
  exports : [BagSummaryComponent]
})
export class BagSummaryModule { }
