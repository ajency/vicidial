import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { WeekThemeComponent } from './week-theme.component';

describe('WeekThemeComponent', () => {
  let component: WeekThemeComponent;
  let fixture: ComponentFixture<WeekThemeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ WeekThemeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(WeekThemeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
