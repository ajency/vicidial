import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BetterPromoAvailableComponent } from './better-promo-available.component';

describe('BetterPromoAvailableComponent', () => {
  let component: BetterPromoAvailableComponent;
  let fixture: ComponentFixture<BetterPromoAvailableComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BetterPromoAvailableComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BetterPromoAvailableComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should be created', () => {
    expect(component).toBeTruthy();
  });
});
