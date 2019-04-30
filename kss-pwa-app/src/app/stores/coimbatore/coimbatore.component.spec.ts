import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CoimbatoreComponent } from './coimbatore.component';

describe('CoimbatoreComponent', () => {
  let component: CoimbatoreComponent;
  let fixture: ComponentFixture<CoimbatoreComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CoimbatoreComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CoimbatoreComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
