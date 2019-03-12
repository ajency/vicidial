import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ProductPageComponent } from './product-page/product-page.component';
import { ProductImgSliderComponent } from './components/product-img-slider/product-img-slider.component';
import { ColorOptionsComponent } from './components/color-options/color-options.component';
import { ProductInfoComponent } from './components/product-info/product-info.component';

import { ComponentsModule } from '../components/components.module';

import { LazyLoadImageModule, intersectionObserverPreset } from 'ng-lazyload-image';

@NgModule({
  declarations: [ProductPageComponent, ProductImgSliderComponent, ColorOptionsComponent, ProductInfoComponent],
  imports: [
    CommonModule,
    ComponentsModule,
    LazyLoadImageModule.forRoot({
          preset: intersectionObserverPreset
  	})
  ]
})
export class ProductPageModule { }
