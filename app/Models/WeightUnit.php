<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeightUnit extends Model {

    use HasFactory;
    use SoftDeletes;

    protected $table = 'tk_weight_unit';
    public $timestamps = true;
    protected $softDelete = true;
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function getStatus() {
        return $this->belongsTo('App\Models\Status', 'status', 'status_code');
    }

}
