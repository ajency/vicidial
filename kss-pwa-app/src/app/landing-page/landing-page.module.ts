import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { LandingPageComponent } from './landing-page/landing-page.component';
import { LandingPageRoutingModule } from './landing-page-routing.module';
import { ComponentsModule } from '../components/components.module';

@NgModule({
  declarations: [LandingPageComponent],
  imports: [
    CommonModule,
    ComponentsModule,
    LandingPageRoutingModule
  ]
})
export class LandingPageModule { }
