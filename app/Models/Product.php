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
        'attributes',
        'additional_information',
    ];
    protected $casts = [
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    // Model Api Get Product
    public function getProductModel()
    {
        DB::beginTransaction();
        try {
            $cats = TaxonomyItem::select('taxonomy_items.id', 'taxonomy_items.name as taxonomy_item_name', 'taxonomy_items.image as taxonomy_item_image')
                ->get();
            if ($cats->count() != 0) {
                foreach ($cats as $c) {
                    $item_cat = ItemCategory::where('item_categories.taxonomy_item_id', '=', $c->id)->get();
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
                        $results[] = $datas;
                    }
                }
                return $results;
            }
            return false;
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json('Product Not failed', 401);
        }
    }

    // Model Api Get Detail Product
    public function getDetailProductModel($id)
    {
        try {
            $detail_products=Product::with('item')->find($id);
            if (!isset($detail_products) and empty($detail_products)) {
                return response()->json([
                    'success'  => false,
                    'message'  => 'Invalid ID supplied'],401);
            }
            return response()->json([
                'success'  => true,
                'data'     => $detail_products,
                'message'  => 'Get data success'],200);

        }catch (\Exception $e) {
            return response()->json('Internal Server Error', 500);
        }
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
