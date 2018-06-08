import { Injectable, ErrorHandler } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'

import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { tap, map, catchError } from 'rxjs/operators';

//models
import { Product} from './../models/product';


@Injectable()
export class HomeService {
    public  menu: object;
    public products: object;
    private menu_URL = '/api/product/menu';
    private products_URL = '/api/product/index';


    getMenu()
    {
      return this.http.get(this.menu_URL).pipe(
        tap(menu => `menu = ${JSON.stringify(menu)}`),
        catchError(error => of([])) 
      );
    }
    getProducts(): Observable<Product>
    {
        return this.http.get<Product>(this.products_URL).pipe(
            tap(products => `products = ${JSON.stringify(products)}`),
          );
    }

    constructor( private http: HttpClient ) { }

}
