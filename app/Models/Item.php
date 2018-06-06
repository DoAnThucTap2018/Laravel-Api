<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Item extends Model
{
    use CrudTrait;
    use Sluggable;
    use SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |------------------------------------T----------------------------
    */

    protected $table = 'items';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'unit_id',
        'item_type_id',
        'title',
        'description',
        'summary',
        'tag',
    ];
    // protected $hidden = [];
    // protected $dates = [];
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
                'source' => 'slug_or_title',
            ],
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function item_category()
    {
        return $this->hasMany('App\Models\ItemCategory');
    }
    public function item_type()
    {
        return $this->belongsTo('App\Models\ItemType');
    }
    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }
    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }

    public function taxonomy_item()
    {
        return $this->belongsToMany('App\Models\TaxonomyItem', 'item_categories');
    }
    public function promotion_item()
    {
        return $this->hasMany('App\Models\PromotionItem');
    }
    public function promotion()
    {
        return $this->belongsToMany('App\Models\Promotion', 'promotion_items');
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
    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

