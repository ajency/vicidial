import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { StoreGalleryComponent } from './store-gallery.component';

describe('StoreGalleryComponent', () => {
  let component: StoreGalleryComponent;
  let fixture: ComponentFixture<StoreGalleryComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ StoreGalleryComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(StoreGalleryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
