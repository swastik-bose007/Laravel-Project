<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduceName extends Model {

    use HasFactory;
    use SoftDeletes;

    protected $table = 'tk_produce_name';
    public $timestamps = true;
    protected $softDelete = true;
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function getCreator() {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function getStatus() {
        return $this->belongsTo('App\Models\Status', 'status', 'status_code');
    }

    public function getProduce() {
        return $this->hasMany('App\Models\Produce', 'produce_name_id');
    }

    public function getCategory() {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
    public function getImage(){
        return $this->hasMany('App\Models\Image','produce_name_id');
    }

    public function getVariant() {
        return $this->hasMany('App\Models\ProduceVariant', 'produce_name_id');
    }

}
