import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { makeStateKey, Title, Meta } from '@angular/platform-browser';
//services
import { TourService } from './../../../services/tours/tour.service';
import { PageService } from './../../../services/page/page.service';
import { MetaTagService} from './../../../services/metaTag/metaTag.service';

//models
import { Tour } from '../../../models/tour';
import { ActivatedRoute } from '@angular/router';
import { MetaTags } from '../../../models/metatags';

@Component({
  selector: 'app-tours',
  templateUrl: './tours.component.html',
  styleUrls: ['./tours.component.scss']
})
export class ToursComponent implements OnInit {
  public message;
  public slug: string;
  public meta: MetaTags;
  public title: string;
  public description: string;
  public keywords: string;
  public image: string;

  public defaultURL;

  public checkMessage: boolean = false;

   tours: Tour[];
  constructor(
    private _tourservice: TourService, 
    private route: ActivatedRoute,
    private http: HttpClient,
    private titleService: Title,
    private metaService: Meta,
    private _pageService: PageService,
    private _metaTagService: MetaTagService
  ) {
    this.defaultURL = window.location.href;
    this.getMetaTag(); 
  }

  getToursFromServices(): void 
  {
    this._tourservice.getTours()
    .subscribe(tours => { 
       this.tours = tours;  
       this.checkMessage = true;
    });
  }

  
getMetaTag():void
{
    const slug = 'tours';
    this._pageService.getMeta(slug).subscribe((res:any) => {
    this.meta = res;
    this.title = this.meta.title;
    this.image = this.meta.image;
    this.description = this.meta.description;
    this.keywords = this.meta.keywords;
    this._metaTagService.getDataMetaTags(this.title,this.description,this.image,this.keywords, this.defaultURL);
   
});
}

  ngOnInit() {
    this.getToursFromServices();
  }

}
