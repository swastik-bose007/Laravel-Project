<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produce extends Model {

    use HasFactory;
    use SoftDeletes;

    protected $table = 'tk_produce';
    public $timestamps = true;
    protected $softDelete = true;
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function getProduceName() {
        return $this->belongsTo('App\Models\ProduceName', 'produce_name_id');
    }

    public function getCreator() {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function getStatus() {
        return $this->belongsTo('App\Models\Status', 'status', 'status_code');
    }

    public function getWeightUnit() {
        return $this->belongsTo('App\Models\WeightUnit', 'unit_code');
    }
    public function getVariant() {
        return $this->hasMany('App\Models\ProduceVariant', 'id', 'produce_variant_id');
    }
    
}
