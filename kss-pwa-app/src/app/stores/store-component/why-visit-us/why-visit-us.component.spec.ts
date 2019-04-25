import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { WhyVisitUsComponent } from './why-visit-us.component';

describe('WhyVisitUsComponent', () => {
  let component: WhyVisitUsComponent;
  let fixture: ComponentFixture<WhyVisitUsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ WhyVisitUsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(WhyVisitUsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
