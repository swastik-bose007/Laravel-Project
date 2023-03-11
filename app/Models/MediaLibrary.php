<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaLibrary extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'tk_media_library';
    public $timestamps = true;
    protected $softDelete = true;
    protected $fillable = ['media_url','created_by'];

    
}
