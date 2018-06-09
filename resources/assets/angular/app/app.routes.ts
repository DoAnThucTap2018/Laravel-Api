import { RouterModule, Routes } from '@angular/router';

import { ProductsCategoryComponent } from './components/pages/products-category/products-category.component';
import { ProductComponent } from './components/pages/product/product.component';
import { HomeComponent } from './components/pages/home/home.component';
import { AboutComponent } from './components/pages/about/about.component';
import { ContactComponent } from './components/pages/contact/contact.component';
export const appRoutes: Routes = [
    {
        path: '',
        component: HomeComponent
    },
    {
        path: 'product-category/:id',
        component: ProductsCategoryComponent
    },
    {
        path: 'product/:id',
        component: ProductComponent
    },
    {
        path: 'about',
        component: AboutComponent
    },
    {
        path: 'contact',
        component: ContactComponent
    }
  ];