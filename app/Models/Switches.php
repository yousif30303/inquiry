<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Switches extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'location_id',
        'brand_id',
        'model',
        'port',
        'serial_no',
        'warranty',
        'warranty_expiry_date',
        'ip_address',
        'type',
    ];

    protected $casts=[
        'warranty_expiry_date'=>'date:d-m-Y'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
