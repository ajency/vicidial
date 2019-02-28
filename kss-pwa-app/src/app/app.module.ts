import { BrowserModule } from '@angular/platform-browser';
// import { NgModule } from '@angular/core';
import { NgModule, ErrorHandler, SystemJsNgModuleLoader } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {APP_BASE_HREF} from '@angular/common';
import {HashLocationStrategy, Location, LocationStrategy} from '@angular/common';
import { HttpClientModule } from '@angular/common/http';
import { environment } from '../environments/environment';
import { provideRoutes, RouterModule } from '@angular/router';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ApiService } from './services/api.service';
import { AppService } from './services/app.service';
// import { RouteGuardService } from './services/route-guard.service';

import { AppServiceService } from './service/app-service.service';
import { ApiServiceService } from './service/api-service.service';
// import { AuthGuardService } from './service/auth-guard.service';
import { NumberModule } from './directives/number.module';
import { LoginComponent } from './login/login.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';

import { LazyModule } from '@herodevs/lazy-af';
@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    PageNotFoundComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    AppRoutingModule,
    HttpClientModule,
    NumberModule,
    RouterModule,
    LazyModule
  ],
  providers: [
    ApiService,
    AppService,
    AppServiceService,
    ApiServiceService,
    // AuthGuardService,
    SystemJsNgModuleLoader
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
