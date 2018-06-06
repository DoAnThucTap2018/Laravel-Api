import { Injectable, ErrorHandler } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'
import { Observable } from 'rxjs/Observable'; 
import { of } from 'rxjs/observable/of';
import { tap, map, catchError } from 'rxjs/operators';
import { makeStateKey, Title, Meta } from '@angular/platform-browser';

//models
import { Page } from './../../models/page';
import { MetaTags } from './../../models/metatags';

@Injectable()
export class MetaTagService {
public defaultURL;
  constructor( 
      private http: HttpClient,
      private metaService: Meta,
      private titleService: Title,
    ) {
      this.defaultURL = window.location.host;
   
    }

    getDataMetaTags(
        title: string, 
        description: string,
        image: string,
        keywords: string,
        url: string
     )
     {
        this.titleService.setTitle(title);
        this.metaService.updateTag(
            {name: 'keywords', content: keywords},
          );
        this.metaService.updateTag(
            {name: 'image', content: this.defaultURL+'/uploads/'+image},
        );
        this.metaService.updateTag(
            {name: 'description', content: description},
        );
        this.metaService.updateTag(
            {name: 'twitter:title', content: title},
        );
        this.metaService.updateTag(
            {name: 'twitter:description', content: description},
        );
        this.metaService.updateTag(
            {name: 'twitter:card', content: 'summary'},
        );
        this.metaService.updateTag(
            {name: 'twitter:image:src', content: this.defaultURL+'/uploads/'+image},
        );

        this.metaService.updateTag(
            {property: 'og:title', content: title},
          );
          this.metaService.updateTag(
            {property: 'og:description', content: description},
          );
          this.metaService.updateTag(
            {property: 'og:image', content: this.defaultURL+'/uploads/'+image},
          );
          this.metaService.updateTag(
            {property: 'og:url', content: url},
          );
          this.metaService.updateTag(
            {property: 'og:site_name', content: 'LBMT'},
          );
          this.metaService.updateTag(
            {property: 'og:locale', content: 'en_US'},
          );
          this.metaService.updateTag(
            {property: 'og:type', content: 'website'},
          );
     }
}
