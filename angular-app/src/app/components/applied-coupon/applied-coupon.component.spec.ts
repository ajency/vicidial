import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AppliedCouponComponent } from './applied-coupon.component';

describe('AppliedCouponComponent', () => {
  let component: AppliedCouponComponent;
  let fixture: ComponentFixture<AppliedCouponComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AppliedCouponComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AppliedCouponComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should be created', () => {
    expect(component).toBeTruthy();
  });
});
