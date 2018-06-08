<?php

namespace App\Models;

use DB;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |------------------------------------T----------------------------
    */

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'item_id',
        'price',
        'image',
    ];
    protected $casts = [
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    // Model Api Get list category Product
    public function listProductModel($id)
    {
        DB::beginTransaction();
        try {
            $cats = TaxonomyItem::select('taxonomy_items.id', 'taxonomy_items.name as taxonomy_item_name')
                ->where('taxonomy_items.id',$id)
                ->get();
            if ($cats->count() != 0) {
                foreach ($cats as $c) {
                    $item_cat = ItemCategory::where('item_categories.taxonomy_item_id', '=', $c->id)->get();
                    //return $item_cat;
                    if ($item_cat->count() != 0) {
                        $datas['Category_name'] = $c->taxonomy_item_name;
                        $products = Product::join('items', 'products.item_id', '=', 'items.id')
                            ->select(
                                'items.id',
                                'items.title',
                                'products.price',
                                'products.image as product_image'
                            )
                            ->join('item_categories', 'items.id', '=', 'item_categories.item_id')
                            ->where('item_categories.taxonomy_item_id', '=', $c->id)
                            ->get();
                        DB::commit();
                        $datas['Products'] = $products;
                        $results = $datas;
                    }
                }
                return  response( $results);
            }
            return response()->json([
                'success'  => false,
                'message'  => 'Invalid ID supplied'],200);
            ;
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json('Internal Server Error', 500);
        }
    }


    // Model Api Get Detail Product
    public function detailProductModel($id)
    {
        try {
            $detail_products = Product::join('items', 'products.item_id', '=', 'items.id')
                ->join('units', 'items.unit_id', '=', 'units.id')
                ->select('products.id','products.item_id','products.price','products.image',
                    'items.id','items.item_type_id','items.title','items.slug','items.description','items.summary',
                    'units.name')
                ->where('products.id',$id)
                ->get();
            if (!isset($detail_products) and empty($detail_products)) {
                return response()->json([
                    'success'  => false,
                    'message'  => 'Invalid ID supplied'],200);
            }
            return response()->json([
                'success'  => true,
                'data'     => $detail_products,
                'message'  => 'Get data success'],200);
//
        }catch (\Exception $e) {
            return response()->json('Internal Server Error', 500);
        }
    }

    public function getAllProductModel()
    {
       $cats=TaxonomyItem::select('taxonomy_items.id','taxonomy_items.name as taxonomy_item_name')
        ->get();
        if ($cats->count() != 0) {
            foreach ($cats as $c) {
                $item_cat = ItemCategory::where('item_categories.taxonomy_item_id', '=', $c->id)->get();
                if ($item_cat->count() != 0) {
                    $datas['cat_name'] = $c->taxonomy_item_name;
                    $products = Product::join('items', 'products.item_id', '=', 'items.id')
                        ->join('units', 'items.unit_id', '=', 'units.id')
                        ->select(
                            'items.id',
                            'items.title',
                            'items.slug',
                            'items.description',
                            'items.summary',
                            'products.price',
                            'products.image as product_image',
                            'units.name'
                        )
                        ->join('item_categories', 'items.id', '=', 'item_categories.item_id')
                        ->where('item_categories.taxonomy_item_id', '=', $c->id)
                        ->get();
                    $datas['products'] = $products;
                    $results[] = $datas;
                }
            }
            return $results;
        }
        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "images";
        $destination_path = "default";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            // 3. Save the path to the database
            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
        }
    }
}
