import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { SliderComponent } from './slider/slider.component';
import { ProductComponent } from './product/product.component';
import { NoProductComponent } from './no-product/no-product.component';
import { LoaderComponent } from './loader/loader.component';
import { NoConnectionComponent } from './no-connection/no-connection.component';
import { LazyLoadImageModule, intersectionObserverPreset } from 'ng-lazyload-image';
import { GenderBoxComponent } from './gender-box/gender-box.component';
import { LabelBoxComponent } from './label-box/label-box.component';
import { BlogComponent } from './blog/blog.component';
import { FeaturedBlogComponent } from './featured-blog/featured-blog.component';
import { BackToTopComponent } from './back-to-top/back-to-top.component';
import { MobileProductsComponent } from './mobile-products/mobile-products.component';
import { BreadcrumsComponent } from './breadcrums/breadcrums.component';
import { ProductPriceComponent } from './product-price/product-price.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { ProductViewComponent } from './product-view/product-view.component';
import { QuantityModalComponent } from './quantity-modal/quantity-modal.component';
import { RouterModule } from '@angular/router';

@NgModule({
  declarations: [HeaderComponent, FooterComponent, SliderComponent, ProductComponent, NoProductComponent, LoaderComponent, NoConnectionComponent, GenderBoxComponent, LabelBoxComponent, BlogComponent, FeaturedBlogComponent, BackToTopComponent, MobileProductsComponent, BreadcrumsComponent, ProductPriceComponent, PageNotFoundComponent, ProductViewComponent, QuantityModalComponent],
  imports: [
    CommonModule,
    LazyLoadImageModule.forRoot({
        preset: intersectionObserverPreset
  	}),
  	RouterModule
  ],
  exports : [HeaderComponent, FooterComponent, SliderComponent, ProductComponent, NoProductComponent, LoaderComponent, NoConnectionComponent, GenderBoxComponent, LabelBoxComponent, BlogComponent, BackToTopComponent, MobileProductsComponent, BreadcrumsComponent, ProductPriceComponent, PageNotFoundComponent, ProductViewComponent, QuantityModalComponent]
})
export class ComponentsModule { }
