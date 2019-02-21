import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { HomeRoutingModule } from './home-routing.module';
import { HomePageComponent } from './home-page/home-page.component';
import { BannerComponent } from './components/banner/banner.component';
import { StoriesComponent } from './components/stories/stories.component';
import { CategoriesComponent } from './components/categories/categories.component';
import { TrendingComponent } from './components/trending/trending.component';
import { ComponentsModule } from '../components/components.module';

// import { DeferLoadModule } from '@trademe/ng-defer-load';

import { LazyLoadImageModule, intersectionObserverPreset } from 'ng-lazyload-image';
import { GenderCategoryComponent } from './components/gender-category/gender-category.component';
import { OffersComponent } from './components/offers/offers.component';
import { WeekThemeComponent } from './components/week-theme/week-theme.component';
import { HappeningMonthComponent } from './components/happening-month/happening-month.component';
import { BrandsComponent } from './components/brands/brands.component';

@NgModule({
  declarations: [HomePageComponent, BannerComponent, StoriesComponent, CategoriesComponent, TrendingComponent, GenderCategoryComponent, OffersComponent, WeekThemeComponent, HappeningMonthComponent, BrandsComponent],
  imports: [
    CommonModule,
    HomeRoutingModule,
    ComponentsModule,
    // DeferLoadModule
	LazyLoadImageModule.forRoot({
        preset: intersectionObserverPreset
	})
  ]
})
export class HomeModule { }
