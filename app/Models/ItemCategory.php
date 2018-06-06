<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |------------------------------------T----------------------------
    */
    protected $table = 'item_categories';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'taxonomy_item_id',
        'item_id',
    ];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
    ];
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
    public function taxonomy_item()
    {
        return $this->belongsTo('App\Models\TaxonomyItem');
    }
}
