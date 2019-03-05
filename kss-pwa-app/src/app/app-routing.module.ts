import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { PageNotFoundComponent }    from './page-not-found/page-not-found.component';
import { RouteGuardService as RouteGuard } from './services/route-guard.service';

const routes: Routes = [	
	{ path: '',  loadChildren: './home/home.module#HomeModule'},
	{ path: '**', component : PageNotFoundComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
