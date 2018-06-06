import { Injectable, ErrorHandler } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'


import { Observable } from 'rxjs/Observable'; 
import { of } from 'rxjs/observable/of';
import { tap, map, catchError } from 'rxjs/operators';

//models
import { Page } from './../../models/page';
import { MetaTags } from './../../models/metatags';

@Injectable()
export class PageService {

  private pageURL = '/api/pages';
  private metaTagsURL = '/api/data/metatag';

  getPage(slug: string): Observable<Page> {
    const url = `${this.pageURL}/${slug}`;
    return this.http.get<Page>(url).pipe(
      tap(page => `page = ${JSON.stringify(page)}`),  
    );
  }

  getMeta(page: string): Observable<MetaTags> {
    const url = `${this.metaTagsURL}/${page}`;
    return this.http.get<MetaTags>(url).pipe(
      tap(page => `page = ${JSON.stringify(MetaTags)}`),  
    );
  }

  public loadScript() {        
    var isFound = false;
    var scripts = document.getElementsByTagName("script")
    for (var i = 0; i < scripts.length; ++i) {
        if (scripts[i].getAttribute('src') != null && scripts[i].getAttribute('src').includes("loader")) {
            isFound = true;
        }
    }
    if (!isFound) {
        var dynamicScripts = ["https://static.addtoany.com/menu/page.js"];
        for (var i = 0; i < dynamicScripts .length; i++) {
            let node = document.createElement('script');
            node.src = dynamicScripts [i];
            node.type = 'text/javascript';
            node.async = false;
            node.charset = 'utf-8';
            document.getElementsByTagName('head')[0].appendChild(node);
      }
    }
  } 


  constructor( private http: HttpClient, ) { }

}
