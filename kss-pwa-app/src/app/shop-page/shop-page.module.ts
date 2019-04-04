import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule }   from '@angular/forms';
import { ShopPageRoutingModule } from './shop-page-routing.module';

import { ShopPageComponent } from './shop-page/shop-page.component';

import { ComponentsModule } from '../components/components.module';
import { FilterCheckboxComponent } from './components/filter-checkbox/filter-checkbox.component';
import { FilterRangeComponent } from './components/filter-range/filter-range.component';

@NgModule({
  declarations: [ShopPageComponent, FilterCheckboxComponent, FilterRangeComponent],
  imports: [
    CommonModule,
    ComponentsModule,
    FormsModule,
    ShopPageRoutingModule,
  ]
})
export class ShopPageModule { }