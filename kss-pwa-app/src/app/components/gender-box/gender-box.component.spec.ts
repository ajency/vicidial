import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { GenderBoxComponent } from './gender-box.component';

describe('GenderBoxComponent', () => {
  let component: GenderBoxComponent;
  let fixture: ComponentFixture<GenderBoxComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ GenderBoxComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(GenderBoxComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
