<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'tk_produce_images';
    public $timestamps = true;
    protected $softDelete = true;
    protected $fillable = ['produce_image_url','produce__name_id','slug'];

    
}
