import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import{ ActivatedRoute } from '@angular/router';
import { Product } from './../../../models/product';

import { ProductsCategoryService } from './../../../services/products_category.services';

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.scss']
})
export class ProductComponent implements OnInit {
  public product: Product[];
  constructor(
      private http: HttpClient,
      private route: ActivatedRoute,
      private  _productscategoryService: ProductsCategoryService
  ) {
    this.getProduct();
  }
    getProduct():void
    {
        const id = +this.route.snapshot.paramMap.get('id');
        this._productscategoryService.getProduct(id).subscribe((res:any) => {
            this.product = res['data'];
            console.log(this.product);
        });
    }
  ngOnInit() {

  }
}
