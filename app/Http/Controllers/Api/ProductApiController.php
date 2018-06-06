<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Order;
use App\Models\ItemType;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductApiController extends Controller
{
    // Api Get List Product Category Weed
    public function getListProductCategoryWeed()
    {
        $CategoryWeed=new Product();
        $CategoryWeed=$CategoryWeed->getProductWeedModel();
        return $CategoryWeed;
    }
    // Api Get List Product Category Extract
    public function getListProductCategoryExtract()
    {
        $CategoryExtract=new Product();
        $CategoryExtract=$CategoryExtract->getProductExtractModel();
        return $CategoryExtract;
    }
    // Api Get List Product Category Medical
    public function getListProductCategoryMedical()
    {
        $CategoryMedical=new Product();
        $CategoryMedical=$CategoryMedical->getProductMedicalModel();
        return $CategoryMedical;
    }
    // Api Get List Product Category Other
    public function getListProductCategoryOther()
    {
        $CategoryOther=new Product();
        $CategoryOther= $CategoryOther->getProductOtherModel();
        return  $CategoryOther;
    }

    // Api Get Detail Product
    public function getDetailProduct($id)
    {
        $detail_products=new Product();
        $detail_products=$detail_products->getDetailProductModel($id);
        return $detail_products;
    }

    // Api Get Order Product
    public function getOrderProduct($id)
    {
        $orders=new Order();
        $orders=$orders->getOrderModel($id);
        return $orders;
    }
}
