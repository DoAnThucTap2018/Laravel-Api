import { Component, OnInit, Inject, ViewChild, Output, EventEmitter } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {LOCAL_STORAGE, WebStorageService} from 'angular-webstorage-service';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import{ ActivatedRoute } from '@angular/router';
import { MatStepper } from '@angular/material';
import * as moment from 'moment';
import {MAT_MOMENT_DATE_FORMATS, MomentDateAdapter} from '@angular/material-moment-adapter';
import {DateAdapter, MAT_DATE_FORMATS, MAT_DATE_LOCALE} from '@angular/material/core';
import { ToastrService } from 'ngx-toastr';

//models
import { Tour } from './../../../../models/tour';
import { Customer } from './../../../../models/customer';

//components
import { BookingComponent } from './../../../../components/pages/booking/booking.component';

//services
import { TourService } from './../../../../services/tours/tour.service';
import { RiderService } from './../../../../services/riders/rider.service';
import { CheckoutService } from '../../../../services/checkout/checkout.service';

@Component({
  selector: 'app-riders',
  templateUrl: './riders.component.html',
  styleUrls: ['./riders.component.scss'],
})


export class RidersComponent implements OnInit {
  public date: any;
 @Output() next = new EventEmitter<void>();
  public name: any;
  ridersFormGroup: FormGroup;
  public dataRiders =  [];
  public detailTour: Tour;
  public numberRiders = [];
  public countryId: number;
  formList:object;
  country_code: string;
  titles: Customer[];
  lbmtTshirts: Customer[];
  countries: Customer[];
  constructor( 
    private _formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private http: HttpClient,
    @Inject(LOCAL_STORAGE) private storage: WebStorageService,
    private _riderService: RiderService,
    private _checkoutService: CheckoutService,
    private dateAdapter: DateAdapter<Date>,
    private toastr: ToastrService
   ) { 
    this.dateAdapter.setLocale('ja-JP');
   }

    getRiderArray()
    {
      let riders = this.storage.get("dataBooking");
      for(let i=0; i <= riders.rider-1; i++ )
      {
        this.numberRiders.push(i);
      }
    }

    onSubmitRider(i, stepper: MatStepper)
    {
        if (!this._riderService.ridersFormGroup[i].valid) return 'a';
        this.formList = this._riderService.ridersFormGroup[i].value;  
        this.dataRiders[i] = this.formList;
        let riders = this.dataRiders;
        this.storage.set('riders',riders);
        let numberRiser = this.storage.get("dataBooking").rider;
        setTimeout(() => {
          this.toastr.success('Add Rider Success!');
        }, 2);
        this._riderService.isNext[i] = true;
        if(i == numberRiser-1)
        {
          this._riderService.isValid=true;
          setTimeout(() => {
            this.next.emit();
          }, 0);
        } else{
          setTimeout(() => {
            stepper.next();
          }, 0);
        }
    }

    getTitleFromServices(): void 
    {
      this._checkoutService.getTitle()
      .subscribe(title => { 
         this.titles = title; 
      });
    }

    getlbmtTshirtFromServices(): void 
    {
      this._checkoutService.getlbmtTshirt()
      .subscribe(lbmtTshirts => { 
         this.lbmtTshirts = lbmtTshirts; 
      });
    }

    getCountryFromServices(): void 
    {
      this._checkoutService.getCountry()
      .subscribe(countries => { 
         this.countries = countries; 
      });    
    }

    ngOnInit() {
      this.getTitleFromServices();
      this.getlbmtTshirtFromServices();
      this.getCountryFromServices();
      this.getRiderArray()
      this._riderService.riderForm(this);
     }
}

