import { Component, OnInit, Input, ViewChild, ElementRef } from '@angular/core';
import{ ActivatedRoute } from '@angular/router';
import { makeStateKey, Title, Meta } from '@angular/platform-browser';
import { HttpClient } from '@angular/common/http';

//models
import { Tour } from './../../../models/tour';

//services
import { TourService } from './../../../services/tours/tour.service';
import { PageService } from './../../../services/page/page.service';
import { MetaTagService} from './../../../services/metaTag/metaTag.service';

@Component({
  selector: 'app-tour-detail',
  templateUrl: './tour-detail.component.html',
  styleUrls: ['./tour-detail.component.scss']
})
export class TourDetailComponent implements OnInit {
  @ViewChild('dataContainer') dataContainer: ElementRef;
  @ViewChild('elementDescription') elementDescription: ElementRef;
  public defaultURL;
  public title: string;
  public description: string;
  public image: string;
  public keywords: string;
  public currentURLTourDetail: string;
  loadAPI: Promise<any>;
  public detailTour: Tour;
  public arrMonth = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
  public element;
  public checkMessage: boolean = false;
  constructor
  (
    private http: HttpClient,
    private titleService: Title,
    private metaService: Meta,
    private route: ActivatedRoute,
    private _tourService: TourService,
    private _pageService: PageService,
    private _metaTagService: MetaTagService
  ) {
    this.loadAPI = new Promise((resolve) => {
      this._pageService.loadScript();
      resolve(true);
  });
  this.defaultURL = window.location.href;
    this.getDetailTour();
  }
  loadData(data) {
    this.dataContainer.nativeElement.innerHTML = data;
    
    }
    loadDataDescription(data) {
      this.elementDescription.nativeElement.innerHTML = data;
    }
  getDetailTour():void
  {
    const id = +this.route.snapshot.paramMap.get('id');
    this._tourService.getDetailTour(id).subscribe((res:any) => {
      this.detailTour = res;
      this.checkMessage = true;
      this.keywords = "lbmt,Tour, travel";
      this.title = this.detailTour['item'].title;
      this.description = this.detailTour['item'].summary;
      this.loadData(this.detailTour['item'].description);
      this.loadDataDescription(this.description);
      this.element = this.elementDescription.nativeElement.textContent;
      this.image = this.detailTour.image;
      this.titleService.setTitle(this.title);
      this._metaTagService.getDataMetaTags(this.title,this.element,this.image,this.keywords, this.defaultURL);
    })
  }

  getCheckDate(month: string)
  {
    if (this.detailTour == undefined) return '--';
    let date = this.detailTour['dates'].find(item => item['month'] === month) || '--';
    return date['date'] == undefined ? '--' : date['date'];
  }

  ngOnInit() {
  }

}
