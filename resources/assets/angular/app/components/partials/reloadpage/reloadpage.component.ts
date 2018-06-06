import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-reloadpage',
  templateUrl: './reloadpage.component.html',
  styleUrls: ['./reloadpage.component.scss']
})
export class ReloadpageComponent implements OnInit {
  public checkMessage: boolean = false;
  constructor() { }

  ngOnInit() {
  }

}
