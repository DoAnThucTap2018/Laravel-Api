import { RouterModule, Routes } from '@angular/router';

import { ToursComponent } from './components/pages/tours/tours.component';
import { TourDetailComponent } from './components/pages/tour-detail/tour-detail.component';
import { HomeComponent } from './components/pages/home/home.component';
import { BookingComponent } from './components/pages/booking/booking.component';
import { PageComponent } from './components/pages/page/page.component';
import { SocialComponent } from './components/partials/social/social.component';
import { CheckoutComponent } from './components/pages/checkout/checkout.component';

export const appRoutes: Routes = [
    // {
    //     path: '',
    //     redirectTo: '/home',
    //     pathMatch: 'full'
    // },
    {
        path: '',
        component: HomeComponent 
    },
    {
      path: 'tours',
      component: ToursComponent
    },
    {
      path: 'tours/:id/:slug',
      component: TourDetailComponent, 
    },
    {
      path: 'tours/:id/booking/:slug',
      component: BookingComponent
    },
    {
        path: 'page/:name',
        component: PageComponent
    },
    {

      path: 'checkout',
      component: CheckoutComponent
  }  
  ];