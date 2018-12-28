import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {APP_BASE_HREF} from '@angular/common';
import { HttpModule }    from '@angular/http';
import {HashLocationStrategy, Location, LocationStrategy} from '@angular/common';

import { AppRoutingModule }     from './app-routing.module';

import { AppComponent } from './app.component';

import { AppServiceService } from './service/app-service.service';
import { ApiServiceService } from './service/api-service.service';
import { AuthGuardService } from './service/auth-guard.service';
import { NumbersDirective } from './directives/numbers.directive';

import { LoginComponent } from './login/login.component';

@NgModule({
  declarations: [
    AppComponent,
    NumbersDirective,
    LoginComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    AppRoutingModule,
    HttpModule
  ],
  providers: [
    {provide: LocationStrategy, useClass: HashLocationStrategy},
    AppServiceService,
    ApiServiceService,
    AuthGuardService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { } 
