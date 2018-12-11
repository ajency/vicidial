import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { UpgradeCartComponent } from './upgrade-cart.component';

describe('UpgradeCartComponent', () => {
  let component: UpgradeCartComponent;
  let fixture: ComponentFixture<UpgradeCartComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ UpgradeCartComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(UpgradeCartComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should be created', () => {
    expect(component).toBeTruthy();
  });
});
