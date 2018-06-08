import { RouterModule, Routes } from '@angular/router';

import { ProductsCategoryComponent } from './components/pages/products-category/products-category.component';
import { ProductComponent } from './components/pages/product/product.component';

export const appRoutes: Routes = [
    {
        path: 'product-category/:id',
        component: ProductsCategoryComponent
    },
    {
        path: 'product/:id',
        component: ProductComponent
    }
  ];