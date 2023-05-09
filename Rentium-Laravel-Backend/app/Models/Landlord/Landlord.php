<?php

namespace App\Models\Landlord;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Landlord extends Authenticatable //implements MustVerifyEmail//Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'landlords';

    //hidden from direct json response:
    public $hidden = ['id', 'landlord_password', 'created_at', 'updated_at'];
    //public $visible = [];

    //guarded from direct mass assignment from request:
    protected $guarded = ['id', 'unique_landlord_id', 'landlord_password', 'created_at', 'updated_at'];
    //protected $fillable = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        'is_logged_in' => 'bool',
        'is_email_verified' => 'bool',
        //'email_verified_at' => 'datetime',
    ];
}
