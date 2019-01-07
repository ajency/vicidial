import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule }   from '@angular/forms';

import { EditUserPopupComponent } from './edit-user-popup/edit-user-popup.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule
  ],
  declarations: [EditUserPopupComponent],
  exports : [EditUserPopupComponent]
})
export class EditUserModule { }
