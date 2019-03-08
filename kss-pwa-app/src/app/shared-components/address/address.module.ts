import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule }   from '@angular/forms';

import { AddressComponent } from './address/address.component';
import { NumberModule } from '../../directives/number.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    NumberModule
  ],
  declarations: [AddressComponent],
  exports : [AddressComponent]
})
export class AddressModule { }
