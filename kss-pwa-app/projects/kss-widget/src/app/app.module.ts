import { BrowserModule } from '@angular/platform-browser';
import { NgModule, ModuleWithProviders } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {APP_BASE_HREF} from '@angular/common';
// import { HttpModule }    from '@angular/http';
import { HttpClientModule } from '@angular/common/http';
import {HashLocationStrategy, Location, LocationStrategy} from '@angular/common';

import { AppRoutingModule }     from './app-routing.module';

import { AppComponent } from './app.component';

import { AppServiceService } from './service/app-service.service';
import { ApiServiceService } from './service/api-service.service';
import { AuthGuardService } from './service/auth-guard.service';
import { NumberModule } from './directives/number.module';

import { LoginComponent } from './login/login.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    AppRoutingModule,
    // HttpModule,
    HttpClientModule,
    NumberModule
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

@NgModule({})
export class App1SharedModule{
  static forRoot(): ModuleWithProviders {
    return {
      ngModule: AppModule,
      providers: [
          {provide: LocationStrategy, useClass: HashLocationStrategy},
          AppServiceService,
          ApiServiceService,
          AuthGuardService
      ]
    }
  }
}