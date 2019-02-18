import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { SliderComponent } from './slider/slider.component';
import { ProductComponent } from './product/product.component';
import { NoProductComponent } from './no-product/no-product.component';
import { LoaderComponent } from './loader/loader.component';
import { NoConnectionComponent } from './no-connection/no-connection.component';

@NgModule({
  declarations: [HeaderComponent, FooterComponent, SliderComponent, ProductComponent, NoProductComponent, LoaderComponent, NoConnectionComponent],
  imports: [
    CommonModule
  ],
  exports : [HeaderComponent, FooterComponent, SliderComponent, ProductComponent, NoProductComponent, LoaderComponent, NoConnectionComponent]
})
export class ComponentsModule { }
