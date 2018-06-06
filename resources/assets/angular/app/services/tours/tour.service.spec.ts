import { TestBed, inject } from '@angular/core/testing';

import { TourService } from './tour.service';

describe('ListService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [TourService]
    });
  });

  it('should be created', inject([TourService], (service: TourService) => {
    expect(service).toBeTruthy();
  }));
});
