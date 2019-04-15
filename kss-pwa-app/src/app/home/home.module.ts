import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { HomeRoutingModule } from './home-routing.module';
import { HomePageComponent } from './home-page/home-page.component';
import { BannerComponent } from './components/banner/banner.component';
import { StoriesComponent } from './components/stories/stories.component';
import { CategoriesComponent } from './components/categories/categories.component';
import { TrendingComponent } from './components/trending/trending.component';
import { ComponentsModule } from '../components/components.module';
import { LayoutModule } from '@angular/cdk/layout';
// import { DeferLoadModule } from '@trademe/ng-defer-load';
import { CarouselModule } from 'ngx-owl-carousel-o';

import { LazyLoadImageModule, intersectionObserverPreset } from 'ng-lazyload-image';
import { GenderCategoryComponent } from './components/gender-category/gender-category.component';
import { OffersComponent } from './components/offers/offers.component';
import { WeekThemeComponent } from './components/week-theme/week-theme.component';
import { HappeningMonthComponent } from './components/happening-month/happening-month.component';
import { BrandsComponent } from './components/brands/brands.component';
import { NewOfferComponent } from './components/new-offer/new-offer.component';

@NgModule({
  declarations: [HomePageComponent, BannerComponent, StoriesComponent, CategoriesComponent, TrendingComponent, GenderCategoryComponent, OffersComponent, WeekThemeComponent, HappeningMonthComponent, BrandsComponent, NewOfferComponent],
  imports: [
    CommonModule,
    HomeRoutingModule,
    ComponentsModule,
    LayoutModule,
    CarouselModule,
    // DeferLoadModule
  	LazyLoadImageModule.forRoot({
          preset: intersectionObserverPreset
  	})
  ]
})
export class HomeModule { }
