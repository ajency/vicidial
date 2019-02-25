import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ShippingDetailsComponent } from './shipping-details.component';

describe('ShippingDetailsComponent', () => {
  let component: ShippingDetailsComponent;
  let fixture: ComponentFixture<ShippingDetailsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ShippingDetailsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ShippingDetailsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should be created', () => {
    expect(component).toBeTruthy();
  });
});
