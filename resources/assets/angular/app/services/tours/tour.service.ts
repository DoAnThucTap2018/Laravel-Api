import { Injectable, ErrorHandler } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'

import { Observable } from 'rxjs/Observable'; 
import { of } from 'rxjs/observable/of';
import { tap, map, catchError } from 'rxjs/operators';

//models
import { Tour } from './../../models/tour';

@Injectable()
export class TourService {
  private detailTourURL = 'api/tours/getdetailtour';
  private toursURL = 'api/tours/gettours';
 
  getTours(): Observable<Tour[]> 
  {
    return this.http.get<Tour[]>(this.toursURL).pipe(
      tap(receivedTours => `receivedTours = ${JSON.stringify(receivedTours)}`),
      catchError(error => of([])) 
    );
  }

  getDetailTour(id: number): Observable<Tour> {
    const url = `${this.detailTourURL}/${id}`;
    return this.http.get<Tour>(url).pipe(
      tap(tour => `tour = ${JSON.stringify(tour)}`),  
    );
  }

  constructor( private http: HttpClient ) { }

}
