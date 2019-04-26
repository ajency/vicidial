import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule }   from '@angular/forms';
import { ShopPageRoutingModule } from './shop-page-routing.module';

import { ShopPageComponent } from './shop-page/shop-page.component';

import { ComponentsModule } from '../components/components.module';
import { FilterCheckboxComponent } from './components/filter-checkbox/filter-checkbox.component';
import { Ng5SliderModule } from 'ng5-slider';
import { NgxPaginationModule } from 'ngx-pagination';

@NgModule({
  declarations: [ShopPageComponent, FilterCheckboxComponent],
  imports: [
    CommonModule,
    ComponentsModule,
    FormsModule,
    ShopPageRoutingModule,
    Ng5SliderModule,
    NgxPaginationModule
  ]
})
export class ShopPageModule { }