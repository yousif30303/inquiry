<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nvr extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'location_id',
        'brand_id',
        'ip_address',
        'model',
        'port',
        'serial_no',
        'dyn_dns',
        'username',
        'channel',
        'storage',
        'server_port',
        'http_port',
        'remark',
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
