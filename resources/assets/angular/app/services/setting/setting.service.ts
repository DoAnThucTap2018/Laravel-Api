import { Injectable, ErrorHandler, Inject, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'
import{ ActivatedRoute } from '@angular/router';
import {LOCAL_STORAGE, WebStorageService} from 'angular-webstorage-service';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';

import { Observable } from 'rxjs/Observable'; 
import { of } from 'rxjs/observable/of';
import { tap, map, catchError } from 'rxjs/operators';

//models
import { Setting } from './../../models/setting';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable()
export class SettingService {
  private settingAPI = 'api/data/setting';

  constructor( 
    private http: HttpClient,
    private route: ActivatedRoute,
   ) { }

   getSetting(key: string): Observable<Setting> {
    const url = `${this.settingAPI}/${key}`;
    return this.http.get<Setting>(url).pipe(
      tap(value => `value = ${JSON.stringify(value)}`),  
    );
  }


   

}
