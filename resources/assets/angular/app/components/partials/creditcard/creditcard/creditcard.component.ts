import { Component, OnInit, ViewChild, ElementRef, Inject, Output, EventEmitter, OnDestroy } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { LOCAL_STORAGE, WebStorageService } from 'angular-webstorage-service';
import { AsyncPipe } from '@angular/common';
import { BookingService } from './../../../../services/booking/booking.service';
import { MatStepper } from '@angular/material';

// services
import { CheckoutService } from './../../../../services/checkout/checkout.service';
import { CreditCardService } from '../../../../services/creditCard/creditcard.service';

//models
import { Customer } from './../../../../models/customer';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { RiderService } from '../../../../services/riders/rider.service';

@Component({
  moduleId: module.id,
  selector: 'app-creditcard',
  templateUrl: './creditcard.component.html',
  styleUrls: ['./creditcard.component.scss'],

})
export class CreditcardComponent implements OnInit, OnDestroy {
  public months:any = [1,2,3,4,5,6,7,8,9,10,11,12];
  public years:any = [2018,2019,2020,2021,2022,2023,2024,2025];
  @Output() next = new EventEmitter<void>();
  message: string;
  creditCardFormGroup: FormGroup;
  public data: object;
  public totalPrice: string;
  private subject: BehaviorSubject<any> = new BehaviorSubject(false);
  public checkMessage: boolean = true; 
  public checkPayment: boolean = false;
  constructor(
    private _formBuilder: FormBuilder,
    private _bookingService: BookingService,
    private _checkoutService: CheckoutService,
    private _riderService: RiderService,
    @Inject(LOCAL_STORAGE) private storage: WebStorageService,
    private _creditCardService: CreditCardService
  ) {
    this.subject.subscribe(next => {
      if (next) {
        this._riderService.isValid = false;
        this._creditCardService.isNext = false;
        setTimeout(() => {
          this.next.emit();
          this._creditCardService.isSubmit = true;
          window.document.getElementById('btn').click();
        }, 0);
      }
    })
  }

  getToken() {
    this.checkMessage=false;
    document.getElementById("checkoutDisplay").style.display="block";
    if (this._creditCardService.isSubmit) return this.message = '';
    this._creditCardService.isNext = true;
    window['Stripe'].card.createToken({
      number: this.creditCardFormGroup.value.cardNumber,
      exp_month: this.creditCardFormGroup.value.expiryMonth,
      exp_year: this.creditCardFormGroup.value.expiryYear,
      cvc: this.creditCardFormGroup.value.cvc
      
    }, (status: number, response: any) => {
      if (status === 200) {  
        this.storage.set('card_id', response.id);
        let book = this.storage.get('dataBooking');
        let riders = this.storage.get('riders');
        let card_id = response.id;
        this.data = {
          book,
          riders,
          card_id
        }
        this._creditCardService.addPayment(this.data as Customer)
          .subscribe(
            book => {    
              this.checkPayment = true;
              JSON.stringify(book);
              this.subject.next(true);
            },           
            (err )=>{
              this._creditCardService.isNext = false;
            }
          );
      } else {
        window.document.getElementById('message').innerText = response.error.message;
        this.message = response.error.message;
        this._creditCardService.isNext = false;
        document.getElementById("checkoutDisplay").style.display="none"; 
      }
    }, err => {
      console.log(err);
    });
  }

  ngOnInit() {
    this._creditCardService.creditCardForm(this);
    this._bookingService.loadScript('https://checkout.stripe.com/checkout.js');
    this._bookingService.loadScript('https://js.stripe.com/v2/');
    this.totalPrice = this.storage.get("dataBooking");
  }

  ngOnDestroy() {
    this.subject.unsubscribe();
  }
}
