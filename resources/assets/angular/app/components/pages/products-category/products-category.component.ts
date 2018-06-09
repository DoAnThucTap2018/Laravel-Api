import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import{ ActivatedRoute } from '@angular/router';

import { Product } from './../../../models/product';

import { ProductsCategoryService } from './../../../services/products_category.services';

// services
import { HomeService } from './../../../services/home.services';

@Component({
  selector: 'app-products-category',
  templateUrl: './products-category.component.html',
  styleUrls: ['./products-category.component.scss']
})
export class ProductsCategoryComponent implements OnInit {
  public menu: object;
public products_category: Product[];
  constructor(
      private http: HttpClient,
      private route: ActivatedRoute,
      private  _productscategoryService: ProductsCategoryService,
      private _homeService: HomeService
  ) {
    this.getProductsCategory();
    this.getMenu();
  }
    getProductsCategory():void
    {
        const id = +this.route.snapshot.paramMap.get('id');
        this._productscategoryService.getProductsCategory(id).subscribe((res:any) => {
            this.products_category = res;
        });
    }
    getMenu(): void 
    {
      this._homeService.getMenu()
      .subscribe(menu => { 
         this.menu = menu;  
      });
    }
  ngOnInit() {

  }

}
