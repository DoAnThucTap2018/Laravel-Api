import { Component, OnInit, OnDestroy, ViewChild, ElementRef } from '@angular/core';
import{ ActivatedRoute, Router, NavigationEnd } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { makeStateKey, Title, Meta } from '@angular/platform-browser';
import { HttpClient } from '@angular/common/http';
import { ToastrService } from 'ngx-toastr';

//models
import { Page } from './../../../models/page';
import { Contact } from './../../../models/contact';
import { MetaTags } from '../../../models/metatags';

//service
import { PageService } from './../../../services/page/page.service';
import { ContactService } from './../../../services/contact/contact.service';
import { MetaTagService} from './../../../services/metaTag/metaTag.service';

@Component({
  selector: 'app-page',
  templateUrl: './page.component.html',
  styleUrls: ['./page.component.scss']
})
export class PageComponent implements OnInit {
  public defaultURL;
  public currentURLPage: string;
  @ViewChild('dataContainer') dataContainer: ElementRef;
  public meta: MetaTags;
  public title: string;
  public description: string;
  public keywords: string;
  public image: string;
  public picture: string;
  public background_color;
  public title_color;
  public dataContact: object;
  public contact: Contact[];
  submitted = false;
  public frmUser: FormGroup;
  public page: Page;
  public subscribePage: any;
  loadAPI: Promise<any>;
  formContact = false;
  public checkMessage: boolean = false;
  constructor(
    private http: HttpClient,
    private titleService: Title,
    private metaService: Meta,
    private _formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private currentRoute: Router,
    private _pageService: PageService,
    private _contactservice: ContactService,
    private _metaTagService: MetaTagService,
    private toastr: ToastrService
  ) 
  {
    this.defaultURL = window.location.href;
    this.getMetaTag();
    this.currentRoute.routeReuseStrategy.shouldReuseRoute = function(){
      return false;
    }
    this.currentRoute.events.subscribe((evt) => {
      if (evt instanceof NavigationEnd) {
         this.currentRoute.navigated = false;
         window.scrollTo(0, 0);
      }
    });
    

    this.loadAPI = new Promise((resolve) => {
      this._pageService.loadScript();
      resolve(true);
  });

  }

  loadData(data) {
    this.dataContainer.nativeElement.innerHTML = data;
}

getMetaTag():void
{
  const slug = this.route.snapshot.params.name;
    this.subscribePage = this._pageService.getMeta(slug).subscribe((res:any) => {
      this.meta = res;
      this.title = this.meta.title;
      this.image = this.meta.image;
      this.description = this.meta.description;
      this.keywords = this.meta.keywords;
      this._metaTagService.getDataMetaTags(this.title,this.description,this.image,this.keywords,this.defaultURL);

    })
}

  getDetailPage():void
  {
    const slug = this.route.snapshot.params.name;
    this.subscribePage = this._pageService.getPage(slug).subscribe((res:any) => {
      this.page = res; 
      this.checkMessage = true;
      this.loadData(this.page.content);
    }) 
    if(slug == 'contact')
    {
      this.formContact = true;
    }
  }

  ngOnInit() {
    const title = this.route.snapshot.params.name;
    this.getDetailPage();
    this.createForm();
  }
  ngOnDestroy() {
    this.subscribePage.unsubscribe();
  }

  createForm() {
    this.frmUser = this._formBuilder.group({
      firstname: ['', [ Validators.required ]],
      lastname: ['', [ Validators.required ]],
      email: ['', [ Validators.required, Validators.pattern('[a-zA-Z0-9._-]+[@]+[a-zA-Z0-9-]+[.]+[a-zA-Z]{2,6}')]],
      phone: ['', [ Validators.required ]],
      message: ['', [ Validators.required ]]
    });
  }

  onSubmitForm() {
      this.dataContact = this.frmUser.value;
      this._contactservice.addContact(this.dataContact as Contact)
      .subscribe(contact => JSON.stringify(contact));
      this.toastr.success('Send Message success!');
      this.frmUser.reset();
  }

  onResetForm() {
    this.frmUser.reset();
  }


}