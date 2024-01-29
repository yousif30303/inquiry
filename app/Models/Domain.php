<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Domain extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'service_provider',
        'ser_pro_email',
        'ser_pro_no',
        'registeration_date',
        'expire_date',
        'domain_link',
        'username',
        'password',
        'remarks',

    ];

}
