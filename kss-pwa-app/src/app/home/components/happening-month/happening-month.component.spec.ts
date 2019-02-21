import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { HappeningMonthComponent } from './happening-month.component';

describe('HappeningMonthComponent', () => {
  let component: HappeningMonthComponent;
  let fixture: ComponentFixture<HappeningMonthComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ HappeningMonthComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(HappeningMonthComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
