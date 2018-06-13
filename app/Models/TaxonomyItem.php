<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class TaxonomyItem extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |------------------------------------T----------------------------
    */

    protected $table = 'taxonomy_items';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'parent_id',
        'taxonomy_id',
        'name',
        'slug',
        'image'
    ];

    protected $casts = [
    ];
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_name',
            ],
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getTaxonomyidAttribute($value)
    {
        return Taxonomy::find($value)->name;
    }
    /**
     * Get all menu items, in a hierarchical collection.
     * Only supports 2 levels of indentation.
     */
    public static function getTree()
    {
        $taxonomy = self::orderBy('lft')->get();

        if ($taxonomy->count()) {
            foreach ($taxonomy as $k => $taxonomy_item) {
                $taxonomy_item->children = collect([]);
                foreach ($taxonomy as $i => $taxonomy_subitem) {
                    if ($taxonomy_subitem->parent_id == $taxonomy_item->id) {
                        $taxonomy_item->children->push($taxonomy_subitem);

                        // remove the subitem for the first level
                        $taxonomy = $taxonomy->reject(function ($item) use ($taxonomy_subitem) {
                            return $item->id == $taxonomy_subitem->id;
                        });
                    }
                }
            }
        }

        return $taxonomy;
    }
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS API
    |--------------------------------------------------------------------------
    */
    public function getMenuModel()
    {
        try {
            $cats = TaxonomyItem::select('taxonomy_items.id', 'taxonomy_items.name as taxonomy_item_name')
                ->get();
            return response($cats);


        }catch (\Exception $e) {
            return response()->json('Internal Server Error', 500);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function item_category()
    {
        return $this->hasMany('App\Models\ItemCategory');
    }
    public function taxonomy()
    {
        return $this->belongsTo('App\Models\Taxonomy');
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\TaxonomyItem', 'parent_id');
    }
    public function children()
    {
        return $this->hasMany('App\Models\TaxonomyItem', 'parent_id');
    }
    public function item()
    {
        return $this->belongsToMany('App\Models\Item', 'item_categories');
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }
        return $this->name;
    }

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

