<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduceVariant extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'tk_produce_variants';
    public $timestamps = true;
    protected $softDelete = true;
    protected $fillable = ['name','produce_name_id','slug'];


    public function getStatus() {
        return $this->belongsTo('App\Models\Status', 'status', 'status_code');
    }

    public function getWeightUnit() {
        return $this->belongsTo('App\Models\WeightUnit', 'weight_unit_code');
    }

    public function getProduceName() {
        return $this->belongsTo('App\Models\ProduceName', 'produce_name_id');
    }

}
