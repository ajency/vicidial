import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CancelCodComponent } from './cancel-cod.component';

describe('CancelCodComponent', () => {
  let component: CancelCodComponent;
  let fixture: ComponentFixture<CancelCodComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CancelCodComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CancelCodComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
