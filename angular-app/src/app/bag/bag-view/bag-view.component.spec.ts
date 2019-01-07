import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BagViewComponent } from './bag-view.component';

describe('BagViewComponent', () => {
  let component: BagViewComponent;
  let fixture: ComponentFixture<BagViewComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BagViewComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BagViewComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should be created', () => {
    expect(component).toBeTruthy();
  });
});
