<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {

    use HasFactory;
    use SoftDeletes;

    // soft delete
    protected $softDelete = true;
    protected $table = 'tk_category';
    public $timestamps = true;

    protected $fillable = [];

    protected $hidden = [];

    protected $casts = [];

    public function getStatus() {
        return $this->belongsTo('App\Models\Status', 'status', 'status_code');
    }

    public function getParent() {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

}
