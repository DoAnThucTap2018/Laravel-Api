import { Injectable, ErrorHandler } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'

import { Observable } from 'rxjs/Observable'; 
import { of } from 'rxjs/observable/of';
import { tap, map, catchError } from 'rxjs/operators';

//models
import { Contact } from './../../models/contact';

const httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

@Injectable()
export class ContactService {
  private contactURL = 'api/contact/postcontact';
  constructor( private http: HttpClient ) { }

    addContact (contact: Contact): Observable<Contact> {
        return this.http.post<Contact>(this.contactURL, contact, httpOptions).pipe(
          tap((contact =>`contact = ${JSON.stringify(contact)}`)));    
      }
}
