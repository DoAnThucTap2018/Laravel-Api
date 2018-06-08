<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Order;
use App\Models\ItemType;
use App\Models\Item;
use App\Models\TaxonomyItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductApiController extends Controller
{
    // Api Get List Product Category Weed, Extract, Medical, Other
    public function listProduct($id)
    {
        $CategoryProduct=new Product();
        $CategoryProduct=$CategoryProduct ->listProductModel($id);
        return $CategoryProduct;
    }

    // Api Get Detail Product
    public function detailProduct($id)
    {
        $detail_products=new Product();
        $detail_products=$detail_products->detailProductModel($id);
        return $detail_products;
    }

    // Api Get Order Product
    public function orderProduct($id)
    {
        $orders=new Order();
        $orders=$orders->getOrderModel($id);
        return $orders;
    }
    public function menu()
    {
        $menu=new TaxonomyItem();
        $menu=$menu->getMenuModel();
        return $menu;
    }
    public function index()
    {
        $allProduct=new Product();
        $allProduct=  $allProduct->getAllProductModel();
        return  $allProduct;
    }
}
