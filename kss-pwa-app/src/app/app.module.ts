import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { environment } from '../environments/environment';
import { RouterModule } from '@angular/router';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';

import { AppServiceService } from './service/app-service.service';
import { ApiServiceService } from './service/api-service.service';
import { AuthGuardService } from './service/auth-guard.service';
import { GlobalErrorHandlerService } from './service/global-error-handler.service';

import { NumberModule } from './directives/number.module';
import { LoginComponent } from './login/login.component';
import { WidgetComponent } from './widget/widget.component';

import { LazyModule } from '@herodevs/lazy-af';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { Ng5SliderModule } from 'ng5-slider';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    WidgetComponent,
  ],
  imports: [
    BrowserModule,
    FormsModule,
    AppRoutingModule,
    HttpClientModule,
    NumberModule,
    RouterModule,
    LazyModule,
    BrowserAnimationsModule,
    Ng5SliderModule
  ],
  providers: [
    AppServiceService,
    ApiServiceService,
    AuthGuardService,
    GlobalErrorHandlerService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
