import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { environment } from '../environments/environment';
import { RouterModule } from '@angular/router';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
// import { ApiService } from './services/api.service';
import { AppService } from './services/app.service';
import { RouteGuardService } from './services/route-guard.service';

import { AppServiceService } from './service/app-service.service';
import { ApiServiceService } from './service/api-service.service';
import { AuthGuardService } from './service/auth-guard.service';
import { NumberModule } from './directives/number.module';
import { LoginComponent } from './login/login.component';
import { WidgetComponent } from './widget/widget.component';

import { LazyModule } from '@herodevs/lazy-af';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    WidgetComponent
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
    // ApiService,
    AppService,
    AppServiceService,
    ApiServiceService,
    AuthGuardService,
    RouteGuardService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
