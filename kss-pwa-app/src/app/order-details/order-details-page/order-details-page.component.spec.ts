import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { OrderDetailsPageComponent } from './order-details-page.component';

describe('OrderDetailsPageComponent', () => {
  let component: OrderDetailsPageComponent;
  let fixture: ComponentFixture<OrderDetailsPageComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ OrderDetailsPageComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(OrderDetailsPageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
