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
import { ProductsCategoryService } from './services/products_category.services';
import { HomeService } from './services/home.services';
//components
import { AppComponent } from './app.component';
import { HeaderComponent } from './components/partials/header/header.component';
import { FooterComponent } from './components/partials/footer/footer.component';
import { ProductsCategoryComponent } from './components/pages/products-category/products-category.component';
import { ProductComponent } from './components/pages/product/product.component';
import { HomeComponent } from './components/pages/home/home.component';
import { AboutComponent } from './components/pages/about/about.component';
import { ContactComponent } from './components/pages/contact/contact.component';


@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    ProductsCategoryComponent,
    ProductComponent,
    HomeComponent,
    AboutComponent,
    ContactComponent,

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
      ProductsCategoryService,
      HomeService
  ],

  bootstrap: [AppComponent]
})
export class AppModule { }
