import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { StoresRoutingModule } from './stores-routing.module';
import { StoresComponent } from './stores/stores.component';

import { ComponentsModule } from '../components/components.module';
import { SuratComponent } from './surat/surat.component';
import { CoimbatoreComponent } from './coimbatore/coimbatore.component';
import { HyderabadComponent } from './hyderabad/hyderabad.component';
import { JaipurComponent } from './jaipur/jaipur.component';
import { WhyVisitUsComponent } from './store-component/why-visit-us/why-visit-us.component';

@NgModule({
  declarations: [StoresComponent, SuratComponent, CoimbatoreComponent, HyderabadComponent, JaipurComponent, WhyVisitUsComponent],
  imports: [
    CommonModule,
    ComponentsModule,
    StoresRoutingModule,    
  ]
})
export class StoresModule { }
