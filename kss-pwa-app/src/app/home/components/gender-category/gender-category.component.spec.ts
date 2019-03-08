import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { GenderCategoryComponent } from './gender-category.component';

describe('GenderCategoryComponent', () => {
  let component: GenderCategoryComponent;
  let fixture: ComponentFixture<GenderCategoryComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ GenderCategoryComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(GenderCategoryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
