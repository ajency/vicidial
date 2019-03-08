import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { FeaturedBlogComponent } from './featured-blog.component';

describe('FeaturedBlogComponent', () => {
  let component: FeaturedBlogComponent;
  let fixture: ComponentFixture<FeaturedBlogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ FeaturedBlogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(FeaturedBlogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
