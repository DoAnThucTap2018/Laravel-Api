import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { makeStateKey, Title, Meta } from '@angular/platform-browser';
import { DomSanitizer, SafeResourceUrl, SafeUrl } from '@angular/platform-browser';


import { MetaTags } from '../../../models/metatags';

import { PageService } from './../../../services/page/page.service';
import { SettingService } from './../../../services/setting/setting.service';
import { MetaTagService} from './../../../services/metaTag/metaTag.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  public defaultInstagram_link;
  public link_instagram;
  public instagram_link;
  public instagram_name;
  public name_instagram;
  public defaultURL: string;
  public defaultIframe;
  public instagram_button_name;
  public button_name;
  public linkMap;
  public map;
  public meta: MetaTags;
  public title: string;
  public description: string;
  public keywords: string;
  public image: string;
  public currentURL: string;
  public dataSetting: any;
  public checkMessage = false;
  constructor(
    private http: HttpClient,
    private titleService: Title,
    private metaService: Meta,
    private _pageService: PageService,
    private _settingService: SettingService,
    private sanitizer: DomSanitizer,
    private _metaTagService: MetaTagService
  ) {
    this.defaultURL = window.location.href;
    this.instagram_link = 'https://instagram.com/luckybastardmotorcycletours';
    this.linkMap = '//lightwidget.com/widgets/fcb5aa9556655c0b911bbbdb03c8f960.html';
    this.defaultIframe = this.sanitizer.bypassSecurityTrustResourceUrl(this.linkMap);
    this.getMetaTag();
    this.getDataSetting();
  }
  getMetaTag(): void {
          const slug = 'home';
          this._pageService.getMeta(slug).subscribe((res: any) => {
          this.meta = res;
          this.title = this.meta.title;
          this.image = this.meta.image;
          this.description = this.meta.description;
          this.keywords = this.meta.keywords;
          this._metaTagService.getDataMetaTags(this.title, this.description, this.image, this.keywords, this.defaultURL);
        });
    }

  ngOnInit() {
    setTimeout(() => {
     this.checkMessage = true;
    }, 500);
  }

  getDataSetting() {
      this._settingService.getSetting('instagram_name').subscribe((res: any) => {
      this.instagram_name = res;
          if (this.instagram_name) {
            this.name_instagram = this.instagram_name;
          } else {
            this.name_instagram = '@luckybastardmotorcycletours';
          }
      });

    this._settingService.getSetting('instagram_link').subscribe((res: any) => {
      this.defaultInstagram_link = res;
      if (this.defaultInstagram_link) {
          this.link_instagram = this.defaultInstagram_link;
      } else {
          this.link_instagram = this.instagram_link;
      }
    });

    this._settingService.getSetting('instagram_iframe').subscribe((res: any) => {
      this.dataSetting = res;
        if (this.dataSetting) {
          this.map =  this.sanitizer.bypassSecurityTrustResourceUrl(this.dataSetting);
        } else {
          this.map = this.defaultIframe;
        }
    });
    this._settingService.getSetting('instagram_button_name').subscribe((res: any) => {
        this.instagram_button_name = res;
          if (this.instagram_button_name) {
            this.button_name = this.instagram_button_name;
          } else {
            this.button_name = 'Follow on Instagram';
          }
        });
      }
}
