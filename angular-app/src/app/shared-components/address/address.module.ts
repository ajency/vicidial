import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule }   from '@angular/forms';

import { AddressComponent } from './address/address.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule
  ],
  declarations: [AddressComponent],
  exports : [AddressComponent]
})
export class AddressModule { }
