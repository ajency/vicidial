import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { environment } from '../environments/environment';
import { HttpClientModule } from '@angular/common/http';
import { ApiService } from './services/api.service';
import { AppService } from './services/app.service';

// import { DeferLoadModule } from '@trademe/ng-defer-load';
import { LazyLoadImageModule, intersectionObserverPreset } from 'ng-lazyload-image';

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    // DeferLoadModule
    LazyLoadImageModule.forRoot({
        preset: intersectionObserverPreset
    })
  ],
  providers: [ApiService, AppService],
  bootstrap: [AppComponent]
})
export class AppModule { }
