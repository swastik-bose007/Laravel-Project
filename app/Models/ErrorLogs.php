<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ErrorLogs extends Model {

    use HasFactory;
    
    protected $softDelete = true;
    protected $table = 'tk_error_logs';
    public $timestamps = true;
}
