import { Injectable, ErrorHandler, Inject, Output, ViewChild, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'
import{ ActivatedRoute } from '@angular/router';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {LOCAL_STORAGE, WebStorageService} from 'angular-webstorage-service';
                                             
import { Observable } from 'rxjs/Observable'; 
import { of } from 'rxjs/observable/of';
import { tap, map, catchError } from 'rxjs/operators';

//models
import { Customer } from './../../models/customer';

const httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

@Injectable()
export class CreditCardService {
    private paymentAPI = 'api/payment';
    creditCardFormGroup: FormGroup;
    public loginData : object;
    public isNext: boolean = false;
    public isSubmit: boolean = false;
  constructor( 
    private _formBuilder: FormBuilder,
    @Inject(LOCAL_STORAGE) private storage: WebStorageService,
    private http: HttpClient,
    private route: ActivatedRoute,
   ) { 
    this.createCreditCardForm();
   }

   createCreditCardForm()
  {
    this.creditCardFormGroup = this._formBuilder.group({
        cardNumber: ['', Validators.required],
        expiryMonth: ['', Validators.required],
        expiryYear: ['', Validators.required],
        cvc: ['', Validators.required],
      });
  }

   creditCardForm(ctr)
   {
     ctr.creditCardFormGroup = this.creditCardFormGroup;
   }

   getForm() {
     return this.creditCardFormGroup;
   }
 
   addPayment (book: Customer): Observable<Customer> {
    return this.http.post<Customer>(this.paymentAPI, book, httpOptions).pipe(
      tap((customer =>`book = ${JSON.stringify(book)}`)));    
  }

 
}
