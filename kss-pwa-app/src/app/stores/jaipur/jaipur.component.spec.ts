import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { JaipurComponent } from './jaipur.component';

describe('JaipurComponent', () => {
  let component: JaipurComponent;
  let fixture: ComponentFixture<JaipurComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ JaipurComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(JaipurComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
