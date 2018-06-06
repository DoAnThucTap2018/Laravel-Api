import { Injectable, ErrorHandler, Inject, Output, ViewChild, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'
import { ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { LOCAL_STORAGE, WebStorageService } from 'angular-webstorage-service';

import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { tap, map, catchError } from 'rxjs/operators';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable()
export class RiderService {
  public dataRiders = [];
  public ridersFormGroup: Array<FormGroup> = [];
  @Output() next = new EventEmitter<void>();
  public loginData: object;
  public isNext = [];
  public isValid: boolean = false;

  constructor(
    private _formBuilder: FormBuilder,
    @Inject(LOCAL_STORAGE) private storage: WebStorageService,
    private http: HttpClient,
    private route: ActivatedRoute,
  ) {
    this.createRidersForm();
  }

  createRidersForm() {
    let riders = this.storage.get("dataBooking");
    for (let i = 0; i <= riders.rider; i++) {
      this.isNext[i]= false;
      this.ridersFormGroup[i] = this._formBuilder.group({
        firstname: ['', Validators.required],
        lastname: ['', Validators.required],
        gender_id: ['', Validators.required],
        contact_number: ['', Validators.required],
        date_of_birth: ['', Validators.required],
        country_id: ['', Validators.required],
        lbmt_tshirt_id: ['', Validators.required]
      });     
    }  
  }

  riderForm(ctr) {
    ctr.ridersFormGroup = this.ridersFormGroup;
  }

  getForm() {
    return this.ridersFormGroup;
  }

}
