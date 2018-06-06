import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule, HttpRequest, HTTP_INTERCEPTORS } from '@angular/common/http';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { StorageServiceModule} from 'angular-webstorage-service';
import { FormsModule } from '@angular/forms';
import { ReactiveFormsModule } from '@angular/forms';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {CdkTableModule} from '@angular/cdk/table';
import { CreditCardDirectivesModule } from 'angular-cc-library';
import '../../sass/app.scss';
import '../../sass/_variables.scss';
import {DateAdapter, MAT_DATE_FORMATS, MAT_DATE_LOCALE} from '@angular/material/core';
import { MatMomentDateModule } from '@angular/material-moment-adapter';
import {MAT_MOMENT_DATE_FORMATS, MomentDateAdapter} from '@angular/material-moment-adapter';
import {
  MatAutocompleteModule,
  MatButtonModule,
  MatButtonToggleModule,
  MatCardModule,
  MatCheckboxModule,
  MatChipsModule,
  MatDatepickerModule,
  MatDialogModule,
  MatDividerModule,
  MatExpansionModule,
  MatGridListModule,
  MatIconModule,
  MatInputModule,
  MatListModule,
  MatMenuModule,
  MatNativeDateModule,
  MatPaginatorModule,
  MatProgressBarModule,
  MatProgressSpinnerModule,
  MatRadioModule,
  MatRippleModule,
  MatSelectModule,
  MatSidenavModule,
  MatSliderModule,
  MatSlideToggleModule,
  MatSnackBarModule,
  MatSortModule,
  MatStepperModule,
  MatTableModule,
  MatTabsModule,
  MatToolbarModule,
  MatTooltipModule,
} from '@angular/material';

import {platformBrowserDynamic} from '@angular/platform-browser-dynamic';
	import { AsyncPipe } from '@angular/common';

import { HttpModule } from '@angular/http';
//routesnpm install --save @angular/animations
import { appRoutes } from './app.routes';
import { ToastrModule } from 'ngx-toastr';

//services
import { TourService } from './services/tours/tour.service';
import { BookingService } from './services/booking/booking.service';
import { PageService } from './services/page/page.service';
import { ContactService} from './services/contact/contact.service';
import { CheckoutService } from './services/checkout/checkout.service';
import { RiderService } from './services/riders/rider.service';
import { CreditCardService } from './services/creditCard/creditcard.service';
import { SettingService } from './services/setting/setting.service';
import { MetaTagService } from './services/metaTag/metaTag.service';

//components
import { AppComponent } from './app.component';
import { HeaderComponent } from './components/partials/header/header.component';
import { FooterComponent } from './components/partials/footer/footer.component';
import { ToursComponent } from './components/pages/tours/tours.component';
import { TourDetailComponent } from './components/pages/tour-detail/tour-detail.component';
import { HomeComponent } from './components/pages/home/home.component';
import { BookingComponent } from './components/pages/booking/booking.component';
import { PageComponent } from './components/pages/page/page.component';
import { SocialComponent } from './components/partials/social/social.component';
import { CheckoutComponent } from './components/pages/checkout/checkout.component';
import { RidersComponent } from './components/partials/riders/riders/riders.component';
import { CreditcardComponent } from './components/partials/creditcard/creditcard/creditcard.component';
import { SuccessComponent } from './components/partials/success/success.component';
import { ReloadpageComponent } from './components/partials/reloadpage/reloadpage.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    ToursComponent,
    TourDetailComponent,
    HomeComponent,
    BookingComponent,
    PageComponent,
    SocialComponent,
    CheckoutComponent,
    RidersComponent,
    CreditcardComponent,
    SuccessComponent,
    ReloadpageComponent,

  ],
  imports: [
    BrowserAnimationsModule,
    ToastrModule.forRoot(),
    // MatMomentDateModule,
    CommonModule,
    CreditCardDirectivesModule,
    BrowserModule.withServerTransition({appId: 'lbmt'}),
    RouterModule.forRoot(appRoutes),
    HttpClientModule,
    StorageServiceModule,
    FormsModule,
    ReactiveFormsModule,
    MatStepperModule,
    BrowserAnimationsModule,
    MatButtonModule,
    MatInputModule,
    MatRippleModule,
    HttpModule,
    MatIconModule,
    CdkTableModule,
    MatAutocompleteModule,
    MatButtonModule,
    MatButtonToggleModule,
    MatCardModule,
    MatCheckboxModule,
    MatChipsModule,
    MatStepperModule,
    MatDatepickerModule,
    MatDialogModule,
    MatDividerModule,
    MatExpansionModule,
    MatGridListModule,
    MatIconModule,
    MatInputModule,
    MatListModule,
    MatMenuModule,
    MatNativeDateModule,
    MatPaginatorModule,
    MatProgressBarModule,
    MatProgressSpinnerModule,
    MatRadioModule,
    MatRippleModule,
    MatSelectModule,
    MatSidenavModule,
    MatSliderModule,
    MatSlideToggleModule,
    MatSnackBarModule,
    MatSortModule,
    MatTableModule,
    MatTabsModule,
    MatToolbarModule,
    MatTooltipModule,
    
  ],
  exports: [
    CdkTableModule,
    MatAutocompleteModule,
    MatButtonModule,
    MatButtonToggleModule,
    MatCardModule,
    MatCheckboxModule,
    MatChipsModule,
    MatStepperModule,
    MatDatepickerModule,
    MatDialogModule,
    MatDividerModule,
    MatExpansionModule,
    MatGridListModule,
    MatIconModule,
    MatInputModule,
    MatListModule,
    MatMenuModule,
    MatNativeDateModule,
    MatPaginatorModule,
    MatProgressBarModule,
    MatProgressSpinnerModule,
    MatRadioModule,
    MatRippleModule,
    MatSelectModule,
    MatSidenavModule,
    MatSliderModule,
    MatSlideToggleModule,
    MatSnackBarModule,
    MatSortModule,
    MatTableModule,
    MatTabsModule,
    MatToolbarModule,
    MatTooltipModule,
  ],

  providers: [
    TourService, 
    BookingService, 
    PageService, 
    ContactService, 
    CheckoutService, 
    RiderService,
    CreditCardService,    
    {provide: MAT_DATE_LOCALE, useValue: 'en-GB'},
    {provide: DateAdapter, useClass: MomentDateAdapter, deps: [MAT_DATE_LOCALE]},
    {provide: MAT_DATE_FORMATS, useValue: MAT_MOMENT_DATE_FORMATS},   
    SettingService,
    MetaTagService
  ],

  bootstrap: [AppComponent]
})
export class AppModule { }
