import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ContactUsRoutingModule } from './contact-us-routing.module';
import { ContactUsComponent } from './contact-us/contact-us.component';

import { ComponentsModule } from '../components/components.module';

@NgModule({
  declarations: [ContactUsComponent],
  imports: [
    CommonModule,
    ComponentsModule,
    ContactUsRoutingModule
  ]
})
export class ContactUsModule { }
