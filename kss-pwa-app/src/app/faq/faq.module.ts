import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FaqRoutingModule } from './faq-routing.module';
import { FaqComponent } from './faq/faq.component';

import { ComponentsModule } from '../components/components.module';

@NgModule({
  declarations: [FaqComponent],
  imports: [
    CommonModule,
    ComponentsModule,
    FaqRoutingModule,
  ]
})
export class FaqModule { }
