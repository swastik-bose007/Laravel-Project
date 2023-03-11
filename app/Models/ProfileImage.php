<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileImage extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'tk_profile_images';
    public $timestamps = true;
    protected $softDelete = true;
    protected $fillable = ['profile_image_url','user_id'];

    
}
