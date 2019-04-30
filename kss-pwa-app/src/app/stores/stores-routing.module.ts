import { NgModule }             from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { StoresComponent } from './stores/stores.component';
import { SuratComponent } from './surat/surat.component';
import { CoimbatoreComponent } from './coimbatore/coimbatore.component';
import { HyderabadComponent } from './hyderabad/hyderabad.component';
import { JaipurComponent } from './jaipur/jaipur.component';

const routes: Routes = [
	{ path: '', component: StoresComponent },
	{ path: 'surat', component: SuratComponent },
	{ path: 'coimbatore', component: CoimbatoreComponent },
	{ path: 'hyderabad', component: HyderabadComponent },
	{ path: 'jaipur', component: JaipurComponent },
	{ path: '**', component: StoresComponent },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [ RouterModule ]
})

export class StoresRoutingModule { }
