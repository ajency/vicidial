import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule }   from '@angular/forms';
import { ProductPageRoutingModule } from './product-page-routing.module';

import { ProductPageComponent } from './product-page/product-page.component';
import { ProductImgSliderComponent } from './components/product-img-slider/product-img-slider.component';
import { ColorOptionsComponent } from './components/color-options/color-options.component';
import { ProductInfoComponent } from './components/product-info/product-info.component';
import { NumberModule } from '../directives/number.module';
import { ComponentsModule } from '../components/components.module';
import { RouterModule } from '@angular/router';
import { LazyLoadImageModule, intersectionObserverPreset } from 'ng-lazyload-image';

@NgModule({
  declarations: [ProductPageComponent, ProductImgSliderComponent, ColorOptionsComponent, ProductInfoComponent],
  imports: [
    CommonModule,
    ComponentsModule,
    FormsModule,
    ProductPageRoutingModule,
    NumberModule,
    RouterModule,
    LazyLoadImageModule.forRoot({
          preset: intersectionObserverPreset
  	})
  ]
})
export class ProductPageModule { }
