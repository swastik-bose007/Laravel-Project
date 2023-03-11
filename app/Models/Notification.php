<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TBNotification extends Model {
    use HasFactory;
    

    protected $table = 'tb_notification';
    public $timestamps = true;
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function getNotificationUser() {
        return $this->hasMany('App\Models\TBNotificationUser', 'notification_id');
    }

}
