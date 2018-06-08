import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import {MediaMatcher} from '@angular/cdk/layout';

// services
import { HomeService } from './../../../services/home.services';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})


export class HeaderComponent implements OnInit {
public menu: object;

    constructor(
      private _homeService: HomeService

    ) {
      this.getMenu();
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
