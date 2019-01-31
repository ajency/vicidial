import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PromotionsListComponent } from './promotions-list/promotions-list.component';
import { PromotionComponent } from './promotion/promotion.component';
import { FormsModule } from '@angular/forms';

@NgModule({
  imports: [
    CommonModule,
    FormsModule
  ],
  declarations: [PromotionsListComponent, PromotionComponent],
  exports: [PromotionsListComponent, PromotionComponent],
})
export class PromotionsModule { }
