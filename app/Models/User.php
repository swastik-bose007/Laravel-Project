<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {

    use HasFactory, Notifiable;
    use HasApiTokens;
    use SoftDeletes;

    // soft delete
    protected $softDelete = true;
    protected $table = 'tk_users';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRoles() {
        return $this->belongsTo('App\Models\UserRoles', 'user_type');
    }

    public function getStatus() {
        return $this->belongsTo('App\Models\Status', 'status', 'status_code');
    }

    public function getCreator() {
        return $this->belongsTo('App\Models\User', 'created_by');
    }
}
