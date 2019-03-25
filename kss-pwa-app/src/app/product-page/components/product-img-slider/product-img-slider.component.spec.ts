import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ProductImgSliderComponent } from './product-img-slider.component';

describe('ProductImgSliderComponent', () => {
  let component: ProductImgSliderComponent;
  let fixture: ComponentFixture<ProductImgSliderComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ProductImgSliderComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ProductImgSliderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
