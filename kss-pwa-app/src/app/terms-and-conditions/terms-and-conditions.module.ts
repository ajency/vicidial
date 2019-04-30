import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { TermsAndConditionsRoutingModule } from './terms-and-conditions-routing.module';
import { TermsAndConditionsComponent } from './terms-and-conditions/terms-and-conditions.component';

import { ComponentsModule } from '../components/components.module';

@NgModule({
  declarations: [TermsAndConditionsComponent],
  imports: [
    CommonModule,
    ComponentsModule,
    TermsAndConditionsRoutingModule,
  ]
})
export class TermsAndConditionsModule { }
