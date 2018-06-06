import { Component, OnInit, Inject, ViewChild, ElementRef } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import { Headers, RequestOptions } from '@angular/http';
import {LOCAL_STORAGE, WebStorageService} from 'angular-webstorage-service';
import { MatStepper } from '@angular/material';
import { makeStateKey, Title, Meta } from '@angular/platform-browser';
import { HttpClient } from '@angular/common/http';

// services 
import { CheckoutService } from './../../../services/checkout/checkout.service';
import { RiderService } from '../../../services/riders/rider.service';
import { CreditCardService } from '../../../services/creditCard/creditcard.service';
import { PageService } from './../../../services/page/page.service';
import { MetaTagService} from './../../../services/metaTag/metaTag.service';

//models
import { Customer } from './../../../models/customer';
import { MetaTags } from '../../../models/metatags';


@Component({
  selector: 'app-checkout',
  templateUrl: './checkout.component.html',
  styleUrls: ['./checkout.component.scss']
})
export class CheckoutComponent implements OnInit {
  public meta: MetaTags;
  public title: string;
  public description: string;
  public keywords: string;
  public image: string;
  public defaultURL;  
  @ViewChild('stepper') stepper: MatStepper;
  public currentURLCheckout: string;
  ridersFormGroup: FormGroup;
  creditCardFormGroup: FormGroup;
  formGroup: FormGroup;
  public selectedIndex = 0;
  public dataTour: object;
  public pay_type: string;
  public checkMessage: boolean = false;
  constructor( 
    private http: HttpClient,
    private titleService: Title,
    private metaService: Meta,
    private _formBuilder: FormBuilder,
    @Inject(LOCAL_STORAGE) private storage: WebStorageService,
    private _checkoutService: CheckoutService,
    private _riderService: RiderService,
    private _creditCardService: CreditCardService,
    private _pageService: PageService,
    private _metaTagService: MetaTagService
   ) { 
     
      this.defaultURL = window.location.href;
      this.getMetaTag();
      this.dataTour = this.storage.get('dataBooking');
     }

     getMetaTag():void
     {
          const slug = 'checkout';
           this._pageService.getMeta(slug).subscribe((res:any) => {
           this.meta = res;
           this.title = this.meta.title;
           this.image = this.meta.image;
           this.description = this.meta.description;
           this.keywords = this.meta.keywords;   
           this.titleService.setTitle(this.title);
           this._metaTagService.getDataMetaTags(this.title,this.description,this.image,this.keywords, this.defaultURL);
         })
     }

  ngOnInit() {
    setTimeout(() => {
      this.checkMessage = true;
     }, 500);
  }

  selectionChange(e) {
    if (e.selectedIndex == 2) {
      this._creditCardService.isSubmit = false;
    }
  }
  
  removeData()
  {
    this.storage.remove('card_id');
    this.storage.remove('dataBooking');
    this.storage.remove('riders');
  }
}