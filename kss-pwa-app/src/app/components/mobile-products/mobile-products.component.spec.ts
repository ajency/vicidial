import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MobileProductsComponent } from './mobile-products.component';

describe('MobileProductsComponent', () => {
  let component: MobileProductsComponent;
  let fixture: ComponentFixture<MobileProductsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MobileProductsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MobileProductsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
