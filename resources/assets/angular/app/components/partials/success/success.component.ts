import { Component, OnInit, Inject } from '@angular/core';
import {LOCAL_STORAGE, WebStorageService} from 'angular-webstorage-service';
import {MatTableDataSource} from '@angular/material';

@Component({
  selector: 'app-success',
  templateUrl: './success.component.html',
  styleUrls: ['./success.component.scss']
})
export class SuccessComponent implements OnInit {
  public dataRiders: any;
  public dataTourBooking: object;
  constructor(
    @Inject(LOCAL_STORAGE) private storage: WebStorageService,
  ) {
    this.getdataTourBooking();
   }

  getdataTourBooking()
  {
      this.dataTourBooking = this.storage.get('dataBooking'); 
      if(this.dataTourBooking['pay_type'] == 0)
      {
        this.dataTourBooking['pay_type'] = 'Pay Deposit (80 %)';
      }else{
        this.dataTourBooking['pay_type'] = 'Full Amount Now';
      }
  }
  
  ngOnInit() {
  }

}
