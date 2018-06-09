import { Injectable, ErrorHandler } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'

import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { tap, map, catchError } from 'rxjs/operators';

//models
import { Product} from './../models/product';


@Injectable()
export class ProductsCategoryService {
    public  products_category: object;
    public product: object;
    private products_categoryURL = '/api/product/listproduct';
    private productURL = '/api/product/detailproduct';
    private relatedURL = '/api/product/category';


    getProductsCategory(id: number): Observable<Product> {
        const url = `${this.products_categoryURL}/${id}`;
        return this.http.get<Product>(url).pipe(
            tap(products => `products = ${JSON.stringify(products)}`),
        );
    }
    getProduct(id: number): Observable<Product> {
        const url = `${this.productURL}/${id}`;
        return this.http.get<Product>(url).pipe(
            tap(product => `product = ${JSON.stringify(product)}`),
        );
    }
    getRelatedProduct(category_id: number, product_id: number)
    {
        const url = `${this.relatedURL}/${category_id}/${product_id}`;
        return this.http.get<Product>(url).pipe(
            tap(relatedProduct => `relatedProduct = ${JSON.stringify(relatedProduct)}`),
        );
    }


    constructor( private http: HttpClient ) { }

}
