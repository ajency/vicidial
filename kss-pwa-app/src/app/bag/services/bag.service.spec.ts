import { TestBed } from '@angular/core/testing';

import { BagService } from './bag.service';

describe('BagService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: BagService = TestBed.get(BagService);
    expect(service).toBeTruthy();
  });
});
