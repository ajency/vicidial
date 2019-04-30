import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { HyderabadComponent } from './hyderabad.component';

describe('HyderabadComponent', () => {
  let component: HyderabadComponent;
  let fixture: ComponentFixture<HyderabadComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ HyderabadComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(HyderabadComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
