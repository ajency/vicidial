import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
// import { App1SharedModule } from "../../projects/kss-widget/src/app/app.module";

const routes: Routes = [
	 { path: '',  loadChildren: './home/home.module#HomeModule' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)
  			// App1SharedModule.forRoot()
  		],
  exports: [RouterModule]
})
export class AppRoutingModule { }
