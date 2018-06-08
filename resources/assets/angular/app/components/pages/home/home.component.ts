import { Component, OnInit } from '@angular/core';
import { Product } from './../../../models/product';
import { HomeService } from './../../../services/home.services';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  public products: Product[];
  constructor(
    private _homeService: HomeService
  ) {
    this.getProducts();
   }

   getProducts():void
   {
       this._homeService.getProducts().subscribe((res:any) => {
           this.products = res['data'];
           console.log(this.products);
       });
   }
  ngOnInit() {
  }

}
