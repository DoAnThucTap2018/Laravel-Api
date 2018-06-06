import { Injectable, ErrorHandler, Inject, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'
import { ActivatedRoute } from '@angular/router';
import {LOCAL_STORAGE, WebStorageService} from 'angular-webstorage-service';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';

import { Observable } from 'rxjs/Observable'; 
import { of } from 'rxjs/observable/of';
import { tap, map, catchError } from 'rxjs/operators';

//models
import { Promotion } from './../../models/promotion';
import { Customer } from './../../models/customer';
import { MatStepper } from '@angular/material/stepper';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable()
export class CheckoutService {
  private checkPromotionAPI = 'api/tours/checkpromotioncode';
  private getTitleAPI = 'api/data/genders';
  private getlbmtTshirtAPI = 'api/data/lbmttshirts';
  private getCountryAPI = 'api/data/countries';

  loginFormGroup: FormGroup;
  ridersFormGroup: FormGroup;
  creditCardFormGroup: FormGroup;
  public data: object;
  public token: string;
  public dataRiders: any;
  public check: boolean;
  checkToken: boolean = false;
  constructor( 
    @Inject(LOCAL_STORAGE) private storage: WebStorageService,
    private http: HttpClient,
    private route: ActivatedRoute,
   ) { }

   
  checkExsistToken()
  {
   if(this.storage.get('login')) {
      this.token = this.storage.get('login').token;

      if(this.token != null)
      {
        this.checkToken = true;
      }else{
        this.checkToken = false;
      } 
    }
  }

   checkPromotion(promotion: object): Observable<Promotion[]> 
   {
     return this.http.post<Promotion[]>(this.checkPromotionAPI, promotion, httpOptions).pipe(
       tap(promotion => `promotion = ${JSON.stringify(promotion)}`),
       catchError(error => of([])) 
     );
   }
 
   getTitle(): Observable<Customer[]> 
   {
     return this.http.get<Customer[]>(this.getTitleAPI).pipe(
       tap(title => `title = ${JSON.stringify(title)}`),
       catchError(error => of([])) 
     );
   }

   getlbmtTshirt(): Observable<Customer[]> 
   {
     return this.http.get<Customer[]>(this.getlbmtTshirtAPI).pipe(
       tap(lbmtTshirt => `lbmtTshirt = ${JSON.stringify(lbmtTshirt)}`),
       catchError(error => of([])) 
     );
   }

   getCountry(): Observable<Customer[]> 
   {
     return this.http.get<Customer[]>(this.getCountryAPI).pipe(
       tap(countries => `countries = ${JSON.stringify(countries)}`),
       catchError(error => of([])) 
     );
   }
}
