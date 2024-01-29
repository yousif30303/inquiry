<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Internet extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'location_id',
        'ip_address',
        'type',
        'provider',
        'account',
        'username',
        'password',
        'speed',
        'router',
        'monthly_rental',
        'remarks',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
