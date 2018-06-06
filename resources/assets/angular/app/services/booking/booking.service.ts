import { Injectable, ErrorHandler, Inject } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'
import{ ActivatedRoute } from '@angular/router';
import {LOCAL_STORAGE, WebStorageService} from 'angular-webstorage-service';
                                             
import { Observable } from 'rxjs/Observable'; 
import { of } from 'rxjs/observable/of';
import { tap, map, catchError } from 'rxjs/operators';

//models
import { Tour } from './../../models/tour';

@Injectable()
export class BookingService {
  
  constructor( 
    @Inject(LOCAL_STORAGE) private storage: WebStorageService,
    private http: HttpClient,
    private route: ActivatedRoute,
   ) { }

   public loadScript(url) {
    let node = document.createElement('script');
    node.src = url;
    node.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(node);
    }

}
