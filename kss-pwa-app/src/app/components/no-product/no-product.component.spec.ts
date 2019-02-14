import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NoProductComponent } from './no-product.component';

describe('NoProductComponent', () => {
  let component: NoProductComponent;
  let fixture: ComponentFixture<NoProductComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NoProductComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NoProductComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
