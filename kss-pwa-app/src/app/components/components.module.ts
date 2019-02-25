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

@NgModule({
  declarations: [HeaderComponent, FooterComponent, SliderComponent, ProductComponent, NoProductComponent, LoaderComponent, NoConnectionComponent, GenderBoxComponent, LabelBoxComponent, BlogComponent, FeaturedBlogComponent],
  imports: [
    CommonModule,
    LazyLoadImageModule.forRoot({
        preset: intersectionObserverPreset
  	})
  ],
  exports : [HeaderComponent, FooterComponent, SliderComponent, ProductComponent, NoProductComponent, LoaderComponent, NoConnectionComponent, GenderBoxComponent, LabelBoxComponent, BlogComponent]
})
export class ComponentsModule { }
