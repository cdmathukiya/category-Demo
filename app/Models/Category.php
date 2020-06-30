<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = "category";

    protected $fillable = ['name', 'slug','parent_id','created_at', 'updated_at'];

    /**
     * Get the index name for the model.
     *
     * @return string
    */
    public function childs() {
        return $this->hasMany('App\Models\Category','parent_id','id') ;
    }
}
