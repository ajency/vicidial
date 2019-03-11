import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { VerifyCodComponent } from './verify-cod.component';

describe('VerifyCodComponent', () => {
  let component: VerifyCodComponent;
  let fixture: ComponentFixture<VerifyCodComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ VerifyCodComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(VerifyCodComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
