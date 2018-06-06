import { Component, ViewChild, ElementRef, OnInit, Inject, Output} from '@angular/core';
import{ ActivatedRoute } from '@angular/router';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import {LOCAL_STORAGE, WebStorageService} from 'angular-webstorage-service';
import{ Location} from '@angular/common';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatRadioChange } from '@angular/material';
import { makeStateKey, Title, Meta } from '@angular/platform-browser';
import { DomSanitizer, SafeResourceUrl, SafeUrl } from '@angular/platform-browser';

//models
import { Tour } from './../../../models/tour';
import { Contact } from './../../../models/contact';
import { Promotion } from './../../../models/promotion';
import { MetaTags } from '../../../models/metatags';

//services
import { TourService } from './../../../services/tours/tour.service';
import { ContactService } from './../../../services/contact/contact.service';
import { BookingService } from './../../../services/booking/booking.service';
import { PageService } from './../../../services/page/page.service';
import { CheckoutService } from './../../../services/checkout/checkout.service';
import { EventEmitter } from 'events';
import { SettingService } from './../../../services/setting/setting.service';
import { MetaTagService} from './../../../services/metaTag/metaTag.service';
import { HomeComponent } from '../home/home.component';

@Component({
  selector: 'app-booking',
  templateUrl: './booking.component.html',
  styleUrls: ['./booking.component.scss']
})
export class BookingComponent implements OnInit {
  public imgURL: string;
  public defaultURL: string;
  public dataSetting: any;
  public linkMap;
  public defaultIframe;
  public map;
  public meta: MetaTags;
  public title: string;
  public description;
  public keywords: string;
  public image: string;
  public currentURLBooking

  @Output() myEvent: EventEmitter = new EventEmitter;
  loadAPI: Promise<any>;
  public frmcontact: FormGroup;
  public frmBooking: FormGroup;
  // @ViewChild('dataContainer') dataContainer: ElementRef;
  @ViewChild('elementDescription') elementDescription: ElementRef;
  public detailTour: Tour;
  public type_tour: number;
  public contact: Contact[];
  public quantityRiders: number;
  public dates: string;
  public riders: string;
  public total_Price: any;
  public selectRider: boolean;
  public numbers = [];
  public buttonDisable :boolean = true;
  public dataContact: object;
  public rider: number;
  public totalPrice: number;
  codePromotion: string;
  public selectedRider: number;
  public dataCheckPromotion: object;
  public code: number;
  public radioPay: any;
  public message: string; 
  public checkClick: boolean = false; 
  public setCode: string;
  public element;
  public checkMessage: boolean = false;
  constructor( 
    private _formBuilder: FormBuilder,
    @Inject(LOCAL_STORAGE) private storage: WebStorageService,
    private route: ActivatedRoute,
    private http: HttpClient,
    private _tourService: TourService,
    private _bookingService: BookingService,
    private _contactservice: ContactService,
    private location: Location,
    private _pageService: PageService,
    private _checkoutService: CheckoutService,
    private titleService: Title,
    private metaService: Meta,
    private _settingService: SettingService,
    private sanitizer: DomSanitizer,
    private _metaTagService: MetaTagService,
   ) { 
    this.defaultURL = window.location.href;
    this.createForm();
    this.linkMap = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3899.155727953794!2d109.18581321454766!3d12.237733033866988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31705d8787fc06ab%3A0x6ad7fbaafbf4f0de!2zOTUgTmfDtCDEkOG7qWMgS-G6vywgVGjDoG5oIHBo4buRIE5oYSBUcmFuZywgS2jDoW5oIEjDsmEgNjUwMDAwLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2sus!4v1524213001248';
    this.defaultIframe = this.sanitizer.bypassSecurityTrustResourceUrl(this.linkMap);    
    this.getDataSetting();
   }

   submitted = false;
    
   // loadData(data) {
   //  this.dataContainer.nativeElement.innerHTML = data;
   //  }
    loadDataDescription(data) {
      this.elementDescription.nativeElement.innerHTML = data;
    }
   getDetailTour():void
    {
          const id = +this.route.snapshot.paramMap.get('id');
          this._tourService.getDetailTour(id).subscribe((res:any) => {
          this.detailTour = res;
          if(this.detailTour['type_tour'] == 1){
            this.type_tour = this.detailTour['type_tour'];
          }
          this.checkMessage = true;
          this.keywords = "lbmt,Tour, travel";
          this.title = this.detailTour['item'].title;
          this.description = this.detailTour['item'].summary;
          this.image = this.detailTour.image;
          // this.loadData(this.detailTour['item'].description);
          this.loadDataDescription(this.description);
          this.element = this.elementDescription.nativeElement.textContent;
          this.titleService.setTitle(this.title);
          this._metaTagService.getDataMetaTags(this.title,this.element,this.image,this.keywords,this.defaultURL);
          for(let i = this.detailTour.min_rider; i <= this.detailTour.max_rider; i++)
          {
            this.numbers.push(i);           
          }
          this.riders = this.numbers[0].toString();
          let data = this.detailTour.price_normal;
          this.rider = +this.riders;
          this.totalPrice = (data * this.rider * 80) / 100;
        }) 
      }
     

    getQuantityRider(event : any)
      {
        this.selectRider = true;    
        let data = this.detailTour.price_normal;

        this.rider = +this.riders;
        if(this.code == undefined && this.frmBooking.value.pay_type == 0){
          this.totalPrice = (data * this.rider);
          this.totalPrice = this.totalPrice * 80 /100;
         }

         if(this.code == undefined && this.frmBooking.value.pay_type == 1){
          this.totalPrice = (data * this.rider);
          this.totalPrice = this.totalPrice;
         }

        if(this.code != undefined && this.frmBooking.value.pay_type == 0){
          this.totalPrice = (data * this.rider) * (100 - this.code) / 100;
          this.totalPrice = this.totalPrice * 80 /100;
         }

         if(this.code != undefined && this.frmBooking.value.pay_type == 1){
          this.totalPrice = (data * this.rider) * (100 - this.code) / 100;
         }
       }

    changeTotalPrice()
    {
        let dataCheckPromotion = {
        "id" : +this.route.snapshot.paramMap.get('id'),
        "code": this.frmBooking.value.code

      }
      this._checkoutService.checkPromotion(dataCheckPromotion as Promotion).subscribe((res:any) => {
        this.code = res;
        if (this.code != 0){
            this.checkClick = true;
            this.message = "sales : " + this.frmBooking.value.code + ' ' + this.code + "%";
            this.totalPrice = (this.totalPrice * 100 / 80) * (100 - this.code) / 100;
            this.totalPrice = this.totalPrice * 80 /100;
            this.codePromotion = '';
        }else{
          this.message = "Code promotion is not valid";
        }   
       
      }) 
    }

    showFormCode(){
      this.checkClick = !this.checkClick;
      this.totalPrice = this.totalPrice * 100 /(100-this.code);
     
    }

    onChange() {
      if(this.frmBooking.value.pay_type == 0)
      {  
        this.totalPrice = this.totalPrice*80/100;
      }
      if(this.frmBooking.value.pay_type == 1){
        this.totalPrice = this.totalPrice * 100/80;
      }  
    }

    getDataFormBooking()
      {
        if(this.frmBooking.value.code == undefined){
          this.setCode = '';
        }else{
          this.setCode = this.frmBooking.value.code;
        }
        if (this.detailTour == undefined) return '--';
        const id = this.detailTour.id;
        let data = {
          "item_id": id,
          "image": this.detailTour.image,
          "rider": +this.riders,
          "date": this.dates,
          "price": this.detailTour.price_normal,
          "name": this.detailTour['item'].title,
          "pay_type": this.frmBooking.value.pay_type,
          "code": this.setCode, 
          "promotion": this.code,
          "totalPrice": this.totalPrice,

        }
        this.storage.set('dataBooking',data);
      }

    createForm()
      {
        this.frmcontact = this._formBuilder.group({
          firstname: ['',[Validators.required ]],
          lastname:['',[Validators.required ]],
          email:['', [Validators.required,Validators.pattern("[a-zA-Z0-9._-]+[@]+[a-zA-Z0-9-]+[.]+[a-zA-Z]{2,6}")]],
          phone:['',[Validators.required ]],
          message:['',[Validators.required ]]
        });

        this.frmBooking = this._formBuilder.group({
          numberRider: [''],
          dates:['',[Validators.required ]],
          code: [''],
          pay_type: ['0']
        });

      }

    onSubmitContact()
      {
        this.submitted = true;
        this.dataContact = this.frmcontact.value;
        this._contactservice.addContact(this.dataContact as Contact)
        .subscribe(contact => JSON.stringify(contact));
      }

    onSubmitBooking()
      {
        this.submitted =  true;
      }
    onResetForm()
      {
        this.submitted = false;
        this.frmcontact.reset();
      }

    ngOnInit() {
    this._bookingService.loadScript('/js/slider.js'); 
    window.document.getElementById('title').innerText = this.route.snapshot.data['title'];
    this.getDetailTour();
  }

  getDataSetting(){
    this._settingService.getSetting('google_map_iframe').subscribe((res:any) => {
    this.dataSetting = res;
    if(this.dataSetting){
    this.defaultURL =  this.dataSetting.value;
    this.map =  this.sanitizer.bypassSecurityTrustResourceUrl(this.dataSetting);
    }else{
      this.map = this.defaultIframe;
    }
    });
  }
  

}
